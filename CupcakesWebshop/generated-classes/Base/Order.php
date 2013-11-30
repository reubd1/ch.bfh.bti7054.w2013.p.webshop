<?php

namespace Base;

use \Billing as ChildBilling;
use \BillingQuery as ChildBillingQuery;
use \CustomItem as ChildCustomItem;
use \CustomItemQuery as ChildCustomItemQuery;
use \Order as ChildOrder;
use \OrderItems as ChildOrderItems;
use \OrderItemsQuery as ChildOrderItemsQuery;
use \OrderQuery as ChildOrderQuery;
use \ShippingAddress as ChildShippingAddress;
use \ShippingAddressQuery as ChildShippingAddressQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\OrderTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class Order implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\OrderTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the order_id field.
     * @var        int
     */
    protected $order_id;

    /**
     * The value for the total field.
     * @var        double
     */
    protected $total;

    /**
     * The value for the order_date field.
     * @var        string
     */
    protected $order_date;

    /**
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the shipping_id field.
     * @var        int
     */
    protected $shipping_id;

    /**
     * The value for the billing_id field.
     * @var        int
     */
    protected $billing_id;

    /**
     * @var        User
     */
    protected $aUser;

    /**
     * @var        Billing
     */
    protected $aBilling;

    /**
     * @var        ShippingAddress
     */
    protected $aShippingAddress;

    /**
     * @var        ObjectCollection|ChildOrderItems[] Collection to store aggregation of ChildOrderItems objects.
     */
    protected $collOrderItemss;
    protected $collOrderItemssPartial;

    /**
     * @var        ObjectCollection|ChildCustomItem[] Collection to store aggregation of ChildCustomItem objects.
     */
    protected $collCustomItems;
    protected $collCustomItemsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $orderItemssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $customItemsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Order object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Order</code> instance.  If
     * <code>obj</code> is an instance of <code>Order</code>, delegates to
     * <code>equals(Order)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return Order The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return Order The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [order_id] column value.
     *
     * @return   int
     */
    public function getOrderId()
    {

        return $this->order_id;
    }

    /**
     * Get the [total] column value.
     *
     * @return   double
     */
    public function getTotal()
    {

        return $this->total;
    }

    /**
     * Get the [optionally formatted] temporal [order_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getOrderDate($format = NULL)
    {
        if ($format === null) {
            return $this->order_date;
        } else {
            return $this->order_date instanceof \DateTime ? $this->order_date->format($format) : null;
        }
    }

    /**
     * Get the [user_id] column value.
     *
     * @return   int
     */
    public function getUserId()
    {

        return $this->user_id;
    }

    /**
     * Get the [shipping_id] column value.
     *
     * @return   int
     */
    public function getShippingId()
    {

        return $this->shipping_id;
    }

    /**
     * Get the [billing_id] column value.
     *
     * @return   int
     */
    public function getBillingId()
    {

        return $this->billing_id;
    }

    /**
     * Set the value of [order_id] column.
     *
     * @param      int $v new value
     * @return   \Order The current object (for fluent API support)
     */
    public function setOrderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->order_id !== $v) {
            $this->order_id = $v;
            $this->modifiedColumns[OrderTableMap::ORDER_ID] = true;
        }


        return $this;
    } // setOrderId()

    /**
     * Set the value of [total] column.
     *
     * @param      double $v new value
     * @return   \Order The current object (for fluent API support)
     */
    public function setTotal($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->total !== $v) {
            $this->total = $v;
            $this->modifiedColumns[OrderTableMap::TOTAL] = true;
        }


        return $this;
    } // setTotal()

    /**
     * Sets the value of [order_date] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Order The current object (for fluent API support)
     */
    public function setOrderDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->order_date !== null || $dt !== null) {
            if ($dt !== $this->order_date) {
                $this->order_date = $dt;
                $this->modifiedColumns[OrderTableMap::ORDER_DATE] = true;
            }
        } // if either are not null


        return $this;
    } // setOrderDate()

    /**
     * Set the value of [user_id] column.
     *
     * @param      int $v new value
     * @return   \Order The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[OrderTableMap::USER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getUserId() !== $v) {
            $this->aUser = null;
        }


        return $this;
    } // setUserId()

    /**
     * Set the value of [shipping_id] column.
     *
     * @param      int $v new value
     * @return   \Order The current object (for fluent API support)
     */
    public function setShippingId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->shipping_id !== $v) {
            $this->shipping_id = $v;
            $this->modifiedColumns[OrderTableMap::SHIPPING_ID] = true;
        }

        if ($this->aShippingAddress !== null && $this->aShippingAddress->getShippingId() !== $v) {
            $this->aShippingAddress = null;
        }


        return $this;
    } // setShippingId()

    /**
     * Set the value of [billing_id] column.
     *
     * @param      int $v new value
     * @return   \Order The current object (for fluent API support)
     */
    public function setBillingId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->billing_id !== $v) {
            $this->billing_id = $v;
            $this->modifiedColumns[OrderTableMap::BILLING_ID] = true;
        }

        if ($this->aBilling !== null && $this->aBilling->getBillingId() !== $v) {
            $this->aBilling = null;
        }


        return $this;
    } // setBillingId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : OrderTableMap::translateFieldName('OrderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->order_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : OrderTableMap::translateFieldName('Total', TableMap::TYPE_PHPNAME, $indexType)];
            $this->total = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : OrderTableMap::translateFieldName('OrderDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->order_date = (null !== $col) ? PropelDateTime::newInstance($col, null, '\DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : OrderTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : OrderTableMap::translateFieldName('ShippingId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shipping_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : OrderTableMap::translateFieldName('BillingId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->billing_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = OrderTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Order object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getUserId()) {
            $this->aUser = null;
        }
        if ($this->aShippingAddress !== null && $this->shipping_id !== $this->aShippingAddress->getShippingId()) {
            $this->aShippingAddress = null;
        }
        if ($this->aBilling !== null && $this->billing_id !== $this->aBilling->getBillingId()) {
            $this->aBilling = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildOrderQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->aBilling = null;
            $this->aShippingAddress = null;
            $this->collOrderItemss = null;

            $this->collCustomItems = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Order::setDeleted()
     * @see Order::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildOrderQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                OrderTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aBilling !== null) {
                if ($this->aBilling->isModified() || $this->aBilling->isNew()) {
                    $affectedRows += $this->aBilling->save($con);
                }
                $this->setBilling($this->aBilling);
            }

            if ($this->aShippingAddress !== null) {
                if ($this->aShippingAddress->isModified() || $this->aShippingAddress->isNew()) {
                    $affectedRows += $this->aShippingAddress->save($con);
                }
                $this->setShippingAddress($this->aShippingAddress);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->orderItemssScheduledForDeletion !== null) {
                if (!$this->orderItemssScheduledForDeletion->isEmpty()) {
                    \OrderItemsQuery::create()
                        ->filterByPrimaryKeys($this->orderItemssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->orderItemssScheduledForDeletion = null;
                }
            }

                if ($this->collOrderItemss !== null) {
            foreach ($this->collOrderItemss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->customItemsScheduledForDeletion !== null) {
                if (!$this->customItemsScheduledForDeletion->isEmpty()) {
                    \CustomItemQuery::create()
                        ->filterByPrimaryKeys($this->customItemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->customItemsScheduledForDeletion = null;
                }
            }

                if ($this->collCustomItems !== null) {
            foreach ($this->collCustomItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[OrderTableMap::ORDER_ID] = true;
        if (null !== $this->order_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OrderTableMap::ORDER_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OrderTableMap::ORDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_ID';
        }
        if ($this->isColumnModified(OrderTableMap::TOTAL)) {
            $modifiedColumns[':p' . $index++]  = 'TOTAL';
        }
        if ($this->isColumnModified(OrderTableMap::ORDER_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'ORDER_DATE';
        }
        if ($this->isColumnModified(OrderTableMap::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'USER_ID';
        }
        if ($this->isColumnModified(OrderTableMap::SHIPPING_ID)) {
            $modifiedColumns[':p' . $index++]  = 'SHIPPING_ID';
        }
        if ($this->isColumnModified(OrderTableMap::BILLING_ID)) {
            $modifiedColumns[':p' . $index++]  = 'BILLING_ID';
        }

        $sql = sprintf(
            'INSERT INTO order (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ORDER_ID':
                        $stmt->bindValue($identifier, $this->order_id, PDO::PARAM_INT);
                        break;
                    case 'TOTAL':
                        $stmt->bindValue($identifier, $this->total, PDO::PARAM_STR);
                        break;
                    case 'ORDER_DATE':
                        $stmt->bindValue($identifier, $this->order_date ? $this->order_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'USER_ID':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'SHIPPING_ID':
                        $stmt->bindValue($identifier, $this->shipping_id, PDO::PARAM_INT);
                        break;
                    case 'BILLING_ID':
                        $stmt->bindValue($identifier, $this->billing_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setOrderId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OrderTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getOrderId();
                break;
            case 1:
                return $this->getTotal();
                break;
            case 2:
                return $this->getOrderDate();
                break;
            case 3:
                return $this->getUserId();
                break;
            case 4:
                return $this->getShippingId();
                break;
            case 5:
                return $this->getBillingId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Order'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Order'][$this->getPrimaryKey()] = true;
        $keys = OrderTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getOrderId(),
            $keys[1] => $this->getTotal(),
            $keys[2] => $this->getOrderDate(),
            $keys[3] => $this->getUserId(),
            $keys[4] => $this->getShippingId(),
            $keys[5] => $this->getBillingId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aBilling) {
                $result['Billing'] = $this->aBilling->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aShippingAddress) {
                $result['ShippingAddress'] = $this->aShippingAddress->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collOrderItemss) {
                $result['OrderItemss'] = $this->collOrderItemss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCustomItems) {
                $result['CustomItems'] = $this->collCustomItems->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OrderTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setOrderId($value);
                break;
            case 1:
                $this->setTotal($value);
                break;
            case 2:
                $this->setOrderDate($value);
                break;
            case 3:
                $this->setUserId($value);
                break;
            case 4:
                $this->setShippingId($value);
                break;
            case 5:
                $this->setBillingId($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = OrderTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setOrderId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTotal($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOrderDate($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setUserId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setShippingId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setBillingId($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(OrderTableMap::DATABASE_NAME);

        if ($this->isColumnModified(OrderTableMap::ORDER_ID)) $criteria->add(OrderTableMap::ORDER_ID, $this->order_id);
        if ($this->isColumnModified(OrderTableMap::TOTAL)) $criteria->add(OrderTableMap::TOTAL, $this->total);
        if ($this->isColumnModified(OrderTableMap::ORDER_DATE)) $criteria->add(OrderTableMap::ORDER_DATE, $this->order_date);
        if ($this->isColumnModified(OrderTableMap::USER_ID)) $criteria->add(OrderTableMap::USER_ID, $this->user_id);
        if ($this->isColumnModified(OrderTableMap::SHIPPING_ID)) $criteria->add(OrderTableMap::SHIPPING_ID, $this->shipping_id);
        if ($this->isColumnModified(OrderTableMap::BILLING_ID)) $criteria->add(OrderTableMap::BILLING_ID, $this->billing_id);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(OrderTableMap::DATABASE_NAME);
        $criteria->add(OrderTableMap::ORDER_ID, $this->order_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getOrderId();
    }

    /**
     * Generic method to set the primary key (order_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setOrderId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getOrderId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Order (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTotal($this->getTotal());
        $copyObj->setOrderDate($this->getOrderDate());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setShippingId($this->getShippingId());
        $copyObj->setBillingId($this->getBillingId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getOrderItemss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrderItems($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCustomItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCustomItem($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setOrderId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \Order Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param                  ChildUser $v
     * @return                 \Order The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getUserId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addOrder($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->user_id !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addOrders($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildBilling object.
     *
     * @param                  ChildBilling $v
     * @return                 \Order The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBilling(ChildBilling $v = null)
    {
        if ($v === null) {
            $this->setBillingId(NULL);
        } else {
            $this->setBillingId($v->getBillingId());
        }

        $this->aBilling = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBilling object, it will not be re-added.
        if ($v !== null) {
            $v->addOrder($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBilling object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildBilling The associated ChildBilling object.
     * @throws PropelException
     */
    public function getBilling(ConnectionInterface $con = null)
    {
        if ($this->aBilling === null && ($this->billing_id !== null)) {
            $this->aBilling = ChildBillingQuery::create()->findPk($this->billing_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBilling->addOrders($this);
             */
        }

        return $this->aBilling;
    }

    /**
     * Declares an association between this object and a ChildShippingAddress object.
     *
     * @param                  ChildShippingAddress $v
     * @return                 \Order The current object (for fluent API support)
     * @throws PropelException
     */
    public function setShippingAddress(ChildShippingAddress $v = null)
    {
        if ($v === null) {
            $this->setShippingId(NULL);
        } else {
            $this->setShippingId($v->getShippingId());
        }

        $this->aShippingAddress = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildShippingAddress object, it will not be re-added.
        if ($v !== null) {
            $v->addOrder($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildShippingAddress object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildShippingAddress The associated ChildShippingAddress object.
     * @throws PropelException
     */
    public function getShippingAddress(ConnectionInterface $con = null)
    {
        if ($this->aShippingAddress === null && ($this->shipping_id !== null)) {
            $this->aShippingAddress = ChildShippingAddressQuery::create()->findPk($this->shipping_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aShippingAddress->addOrders($this);
             */
        }

        return $this->aShippingAddress;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('OrderItems' == $relationName) {
            return $this->initOrderItemss();
        }
        if ('CustomItem' == $relationName) {
            return $this->initCustomItems();
        }
    }

    /**
     * Clears out the collOrderItemss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addOrderItemss()
     */
    public function clearOrderItemss()
    {
        $this->collOrderItemss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collOrderItemss collection loaded partially.
     */
    public function resetPartialOrderItemss($v = true)
    {
        $this->collOrderItemssPartial = $v;
    }

    /**
     * Initializes the collOrderItemss collection.
     *
     * By default this just sets the collOrderItemss collection to an empty array (like clearcollOrderItemss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrderItemss($overrideExisting = true)
    {
        if (null !== $this->collOrderItemss && !$overrideExisting) {
            return;
        }
        $this->collOrderItemss = new ObjectCollection();
        $this->collOrderItemss->setModel('\OrderItems');
    }

    /**
     * Gets an array of ChildOrderItems objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOrder is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildOrderItems[] List of ChildOrderItems objects
     * @throws PropelException
     */
    public function getOrderItemss($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collOrderItemssPartial && !$this->isNew();
        if (null === $this->collOrderItemss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOrderItemss) {
                // return empty collection
                $this->initOrderItemss();
            } else {
                $collOrderItemss = ChildOrderItemsQuery::create(null, $criteria)
                    ->filterByOrder($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collOrderItemssPartial && count($collOrderItemss)) {
                        $this->initOrderItemss(false);

                        foreach ($collOrderItemss as $obj) {
                            if (false == $this->collOrderItemss->contains($obj)) {
                                $this->collOrderItemss->append($obj);
                            }
                        }

                        $this->collOrderItemssPartial = true;
                    }

                    reset($collOrderItemss);

                    return $collOrderItemss;
                }

                if ($partial && $this->collOrderItemss) {
                    foreach ($this->collOrderItemss as $obj) {
                        if ($obj->isNew()) {
                            $collOrderItemss[] = $obj;
                        }
                    }
                }

                $this->collOrderItemss = $collOrderItemss;
                $this->collOrderItemssPartial = false;
            }
        }

        return $this->collOrderItemss;
    }

    /**
     * Sets a collection of OrderItems objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $orderItemss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildOrder The current object (for fluent API support)
     */
    public function setOrderItemss(Collection $orderItemss, ConnectionInterface $con = null)
    {
        $orderItemssToDelete = $this->getOrderItemss(new Criteria(), $con)->diff($orderItemss);


        $this->orderItemssScheduledForDeletion = $orderItemssToDelete;

        foreach ($orderItemssToDelete as $orderItemsRemoved) {
            $orderItemsRemoved->setOrder(null);
        }

        $this->collOrderItemss = null;
        foreach ($orderItemss as $orderItems) {
            $this->addOrderItems($orderItems);
        }

        $this->collOrderItemss = $orderItemss;
        $this->collOrderItemssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OrderItems objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related OrderItems objects.
     * @throws PropelException
     */
    public function countOrderItemss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collOrderItemssPartial && !$this->isNew();
        if (null === $this->collOrderItemss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrderItemss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOrderItemss());
            }

            $query = ChildOrderItemsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrder($this)
                ->count($con);
        }

        return count($this->collOrderItemss);
    }

    /**
     * Method called to associate a ChildOrderItems object to this object
     * through the ChildOrderItems foreign key attribute.
     *
     * @param    ChildOrderItems $l ChildOrderItems
     * @return   \Order The current object (for fluent API support)
     */
    public function addOrderItems(ChildOrderItems $l)
    {
        if ($this->collOrderItemss === null) {
            $this->initOrderItemss();
            $this->collOrderItemssPartial = true;
        }

        if (!in_array($l, $this->collOrderItemss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOrderItems($l);
        }

        return $this;
    }

    /**
     * @param OrderItems $orderItems The orderItems object to add.
     */
    protected function doAddOrderItems($orderItems)
    {
        $this->collOrderItemss[]= $orderItems;
        $orderItems->setOrder($this);
    }

    /**
     * @param  OrderItems $orderItems The orderItems object to remove.
     * @return ChildOrder The current object (for fluent API support)
     */
    public function removeOrderItems($orderItems)
    {
        if ($this->getOrderItemss()->contains($orderItems)) {
            $this->collOrderItemss->remove($this->collOrderItemss->search($orderItems));
            if (null === $this->orderItemssScheduledForDeletion) {
                $this->orderItemssScheduledForDeletion = clone $this->collOrderItemss;
                $this->orderItemssScheduledForDeletion->clear();
            }
            $this->orderItemssScheduledForDeletion[]= clone $orderItems;
            $orderItems->setOrder(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Order is new, it will return
     * an empty collection; or if this Order has previously
     * been saved, it will retrieve related OrderItemss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Order.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildOrderItems[] List of ChildOrderItems objects
     */
    public function getOrderItemssJoinItem($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderItemsQuery::create(null, $criteria);
        $query->joinWith('Item', $joinBehavior);

        return $this->getOrderItemss($query, $con);
    }

    /**
     * Clears out the collCustomItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCustomItems()
     */
    public function clearCustomItems()
    {
        $this->collCustomItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCustomItems collection loaded partially.
     */
    public function resetPartialCustomItems($v = true)
    {
        $this->collCustomItemsPartial = $v;
    }

    /**
     * Initializes the collCustomItems collection.
     *
     * By default this just sets the collCustomItems collection to an empty array (like clearcollCustomItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCustomItems($overrideExisting = true)
    {
        if (null !== $this->collCustomItems && !$overrideExisting) {
            return;
        }
        $this->collCustomItems = new ObjectCollection();
        $this->collCustomItems->setModel('\CustomItem');
    }

    /**
     * Gets an array of ChildCustomItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOrder is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildCustomItem[] List of ChildCustomItem objects
     * @throws PropelException
     */
    public function getCustomItems($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomItemsPartial && !$this->isNew();
        if (null === $this->collCustomItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCustomItems) {
                // return empty collection
                $this->initCustomItems();
            } else {
                $collCustomItems = ChildCustomItemQuery::create(null, $criteria)
                    ->filterByOrder($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCustomItemsPartial && count($collCustomItems)) {
                        $this->initCustomItems(false);

                        foreach ($collCustomItems as $obj) {
                            if (false == $this->collCustomItems->contains($obj)) {
                                $this->collCustomItems->append($obj);
                            }
                        }

                        $this->collCustomItemsPartial = true;
                    }

                    reset($collCustomItems);

                    return $collCustomItems;
                }

                if ($partial && $this->collCustomItems) {
                    foreach ($this->collCustomItems as $obj) {
                        if ($obj->isNew()) {
                            $collCustomItems[] = $obj;
                        }
                    }
                }

                $this->collCustomItems = $collCustomItems;
                $this->collCustomItemsPartial = false;
            }
        }

        return $this->collCustomItems;
    }

    /**
     * Sets a collection of CustomItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $customItems A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildOrder The current object (for fluent API support)
     */
    public function setCustomItems(Collection $customItems, ConnectionInterface $con = null)
    {
        $customItemsToDelete = $this->getCustomItems(new Criteria(), $con)->diff($customItems);


        $this->customItemsScheduledForDeletion = $customItemsToDelete;

        foreach ($customItemsToDelete as $customItemRemoved) {
            $customItemRemoved->setOrder(null);
        }

        $this->collCustomItems = null;
        foreach ($customItems as $customItem) {
            $this->addCustomItem($customItem);
        }

        $this->collCustomItems = $customItems;
        $this->collCustomItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CustomItem objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CustomItem objects.
     * @throws PropelException
     */
    public function countCustomItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCustomItemsPartial && !$this->isNew();
        if (null === $this->collCustomItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCustomItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCustomItems());
            }

            $query = ChildCustomItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrder($this)
                ->count($con);
        }

        return count($this->collCustomItems);
    }

    /**
     * Method called to associate a ChildCustomItem object to this object
     * through the ChildCustomItem foreign key attribute.
     *
     * @param    ChildCustomItem $l ChildCustomItem
     * @return   \Order The current object (for fluent API support)
     */
    public function addCustomItem(ChildCustomItem $l)
    {
        if ($this->collCustomItems === null) {
            $this->initCustomItems();
            $this->collCustomItemsPartial = true;
        }

        if (!in_array($l, $this->collCustomItems->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCustomItem($l);
        }

        return $this;
    }

    /**
     * @param CustomItem $customItem The customItem object to add.
     */
    protected function doAddCustomItem($customItem)
    {
        $this->collCustomItems[]= $customItem;
        $customItem->setOrder($this);
    }

    /**
     * @param  CustomItem $customItem The customItem object to remove.
     * @return ChildOrder The current object (for fluent API support)
     */
    public function removeCustomItem($customItem)
    {
        if ($this->getCustomItems()->contains($customItem)) {
            $this->collCustomItems->remove($this->collCustomItems->search($customItem));
            if (null === $this->customItemsScheduledForDeletion) {
                $this->customItemsScheduledForDeletion = clone $this->collCustomItems;
                $this->customItemsScheduledForDeletion->clear();
            }
            $this->customItemsScheduledForDeletion[]= clone $customItem;
            $customItem->setOrder(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Order is new, it will return
     * an empty collection; or if this Order has previously
     * been saved, it will retrieve related CustomItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Order.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildCustomItem[] List of ChildCustomItem objects
     */
    public function getCustomItemsJoinCake($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCustomItemQuery::create(null, $criteria);
        $query->joinWith('Cake', $joinBehavior);

        return $this->getCustomItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Order is new, it will return
     * an empty collection; or if this Order has previously
     * been saved, it will retrieve related CustomItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Order.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildCustomItem[] List of ChildCustomItem objects
     */
    public function getCustomItemsJoinTopping($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCustomItemQuery::create(null, $criteria);
        $query->joinWith('Topping', $joinBehavior);

        return $this->getCustomItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Order is new, it will return
     * an empty collection; or if this Order has previously
     * been saved, it will retrieve related CustomItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Order.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildCustomItem[] List of ChildCustomItem objects
     */
    public function getCustomItemsJoinDecoration($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCustomItemQuery::create(null, $criteria);
        $query->joinWith('Decoration', $joinBehavior);

        return $this->getCustomItems($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->order_id = null;
        $this->total = null;
        $this->order_date = null;
        $this->user_id = null;
        $this->shipping_id = null;
        $this->billing_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collOrderItemss) {
                foreach ($this->collOrderItemss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCustomItems) {
                foreach ($this->collCustomItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collOrderItemss = null;
        $this->collCustomItems = null;
        $this->aUser = null;
        $this->aBilling = null;
        $this->aShippingAddress = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OrderTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
