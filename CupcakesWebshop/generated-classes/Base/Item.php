<?php

namespace Base;

use \Category as ChildCategory;
use \CategoryQuery as ChildCategoryQuery;
use \Item as ChildItem;
use \ItemDescription as ChildItemDescription;
use \ItemDescriptionQuery as ChildItemDescriptionQuery;
use \ItemQuery as ChildItemQuery;
use \OrderItems as ChildOrderItems;
use \OrderItemsQuery as ChildOrderItemsQuery;
use \Exception;
use \PDO;
use Map\ItemTableMap;
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

abstract class Item implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ItemTableMap';


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
     * The value for the item_id field.
     * @var        int
     */
    protected $item_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the price field.
     * @var        double
     */
    protected $price;

    /**
     * The value for the image field.
     * @var        string
     */
    protected $image;

    /**
     * The value for the available field.
     * @var        boolean
     */
    protected $available;

    /**
     * The value for the category_id field.
     * @var        int
     */
    protected $category_id;

    /**
     * @var        Category
     */
    protected $aCategory;

    /**
     * @var        ObjectCollection|ChildItemDescription[] Collection to store aggregation of ChildItemDescription objects.
     */
    protected $collItemDescriptions;
    protected $collItemDescriptionsPartial;

    /**
     * @var        ObjectCollection|ChildOrderItems[] Collection to store aggregation of ChildOrderItems objects.
     */
    protected $collOrderItemss;
    protected $collOrderItemssPartial;

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
    protected $itemDescriptionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $orderItemssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Item object.
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
     * Compares this with another <code>Item</code> instance.  If
     * <code>obj</code> is an instance of <code>Item</code>, delegates to
     * <code>equals(Item)</code>.  Otherwise, returns <code>false</code>.
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
     * @return Item The current object, for fluid interface
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
     * @return Item The current object, for fluid interface
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
     * Get the [item_id] column value.
     *
     * @return   int
     */
    public function getItemId()
    {

        return $this->item_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return   string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [price] column value.
     *
     * @return   double
     */
    public function getPrice()
    {

        return $this->price;
    }

    /**
     * Get the [image] column value.
     *
     * @return   string
     */
    public function getImage()
    {

        return $this->image;
    }

    /**
     * Get the [available] column value.
     *
     * @return   boolean
     */
    public function getAvailable()
    {

        return $this->available;
    }

    /**
     * Get the [category_id] column value.
     *
     * @return   int
     */
    public function getCategoryId()
    {

        return $this->category_id;
    }

    /**
     * Set the value of [item_id] column.
     *
     * @param      int $v new value
     * @return   \Item The current object (for fluent API support)
     */
    public function setItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_id !== $v) {
            $this->item_id = $v;
            $this->modifiedColumns[ItemTableMap::ITEM_ID] = true;
        }


        return $this;
    } // setItemId()

    /**
     * Set the value of [name] column.
     *
     * @param      string $v new value
     * @return   \Item The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ItemTableMap::NAME] = true;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [price] column.
     *
     * @param      double $v new value
     * @return   \Item The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[ItemTableMap::PRICE] = true;
        }


        return $this;
    } // setPrice()

    /**
     * Set the value of [image] column.
     *
     * @param      string $v new value
     * @return   \Item The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[ItemTableMap::IMAGE] = true;
        }


        return $this;
    } // setImage()

    /**
     * Sets the value of the [available] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \Item The current object (for fluent API support)
     */
    public function setAvailable($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->available !== $v) {
            $this->available = $v;
            $this->modifiedColumns[ItemTableMap::AVAILABLE] = true;
        }


        return $this;
    } // setAvailable()

    /**
     * Set the value of [category_id] column.
     *
     * @param      int $v new value
     * @return   \Item The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[ItemTableMap::CATEGORY_ID] = true;
        }

        if ($this->aCategory !== null && $this->aCategory->getCategoryId() !== $v) {
            $this->aCategory = null;
        }


        return $this;
    } // setCategoryId()

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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemTableMap::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ItemTableMap::translateFieldName('Available', TableMap::TYPE_PHPNAME, $indexType)];
            $this->available = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ItemTableMap::translateFieldName('CategoryId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->category_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = ItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Item object", 0, $e);
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
        if ($this->aCategory !== null && $this->category_id !== $this->aCategory->getCategoryId()) {
            $this->aCategory = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCategory = null;
            $this->collItemDescriptions = null;

            $this->collOrderItemss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Item::setDeleted()
     * @see Item::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildItemQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
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
                ItemTableMap::addInstanceToPool($this);
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

            if ($this->aCategory !== null) {
                if ($this->aCategory->isModified() || $this->aCategory->isNew()) {
                    $affectedRows += $this->aCategory->save($con);
                }
                $this->setCategory($this->aCategory);
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

            if ($this->itemDescriptionsScheduledForDeletion !== null) {
                if (!$this->itemDescriptionsScheduledForDeletion->isEmpty()) {
                    \ItemDescriptionQuery::create()
                        ->filterByPrimaryKeys($this->itemDescriptionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->itemDescriptionsScheduledForDeletion = null;
                }
            }

                if ($this->collItemDescriptions !== null) {
            foreach ($this->collItemDescriptions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[ItemTableMap::ITEM_ID] = true;
        if (null !== $this->item_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ItemTableMap::ITEM_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ItemTableMap::ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ITEM_ID';
        }
        if ($this->isColumnModified(ItemTableMap::NAME)) {
            $modifiedColumns[':p' . $index++]  = 'NAME';
        }
        if ($this->isColumnModified(ItemTableMap::PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'PRICE';
        }
        if ($this->isColumnModified(ItemTableMap::IMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'IMAGE';
        }
        if ($this->isColumnModified(ItemTableMap::AVAILABLE)) {
            $modifiedColumns[':p' . $index++]  = 'AVAILABLE';
        }
        if ($this->isColumnModified(ItemTableMap::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'CATEGORY_ID';
        }

        $sql = sprintf(
            'INSERT INTO item (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ITEM_ID':
                        $stmt->bindValue($identifier, $this->item_id, PDO::PARAM_INT);
                        break;
                    case 'NAME':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'PRICE':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_STR);
                        break;
                    case 'IMAGE':
                        $stmt->bindValue($identifier, $this->image, PDO::PARAM_STR);
                        break;
                    case 'AVAILABLE':
                        $stmt->bindValue($identifier, (int) $this->available, PDO::PARAM_INT);
                        break;
                    case 'CATEGORY_ID':
                        $stmt->bindValue($identifier, $this->category_id, PDO::PARAM_INT);
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
        $this->setItemId($pk);

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
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getItemId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getPrice();
                break;
            case 3:
                return $this->getImage();
                break;
            case 4:
                return $this->getAvailable();
                break;
            case 5:
                return $this->getCategoryId();
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
        if (isset($alreadyDumpedObjects['Item'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Item'][$this->getPrimaryKey()] = true;
        $keys = ItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getItemId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getPrice(),
            $keys[3] => $this->getImage(),
            $keys[4] => $this->getAvailable(),
            $keys[5] => $this->getCategoryId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCategory) {
                $result['Category'] = $this->aCategory->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collItemDescriptions) {
                $result['ItemDescriptions'] = $this->collItemDescriptions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOrderItemss) {
                $result['OrderItemss'] = $this->collOrderItemss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setItemId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setPrice($value);
                break;
            case 3:
                $this->setImage($value);
                break;
            case 4:
                $this->setAvailable($value);
                break;
            case 5:
                $this->setCategoryId($value);
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
        $keys = ItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setItemId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPrice($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setImage($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAvailable($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCategoryId($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemTableMap::ITEM_ID)) $criteria->add(ItemTableMap::ITEM_ID, $this->item_id);
        if ($this->isColumnModified(ItemTableMap::NAME)) $criteria->add(ItemTableMap::NAME, $this->name);
        if ($this->isColumnModified(ItemTableMap::PRICE)) $criteria->add(ItemTableMap::PRICE, $this->price);
        if ($this->isColumnModified(ItemTableMap::IMAGE)) $criteria->add(ItemTableMap::IMAGE, $this->image);
        if ($this->isColumnModified(ItemTableMap::AVAILABLE)) $criteria->add(ItemTableMap::AVAILABLE, $this->available);
        if ($this->isColumnModified(ItemTableMap::CATEGORY_ID)) $criteria->add(ItemTableMap::CATEGORY_ID, $this->category_id);

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
        $criteria = new Criteria(ItemTableMap::DATABASE_NAME);
        $criteria->add(ItemTableMap::ITEM_ID, $this->item_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getItemId();
    }

    /**
     * Generic method to set the primary key (item_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setItemId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getItemId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Item (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setImage($this->getImage());
        $copyObj->setAvailable($this->getAvailable());
        $copyObj->setCategoryId($this->getCategoryId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getItemDescriptions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItemDescription($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOrderItemss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrderItems($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setItemId(NULL); // this is a auto-increment column, so set to default value
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
     * @return                 \Item Clone of current object.
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
     * Declares an association between this object and a ChildCategory object.
     *
     * @param                  ChildCategory $v
     * @return                 \Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCategory(ChildCategory $v = null)
    {
        if ($v === null) {
            $this->setCategoryId(NULL);
        } else {
            $this->setCategoryId($v->getCategoryId());
        }

        $this->aCategory = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCategory object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCategory object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildCategory The associated ChildCategory object.
     * @throws PropelException
     */
    public function getCategory(ConnectionInterface $con = null)
    {
        if ($this->aCategory === null && ($this->category_id !== null)) {
            $this->aCategory = ChildCategoryQuery::create()->findPk($this->category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCategory->addItems($this);
             */
        }

        return $this->aCategory;
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
        if ('ItemDescription' == $relationName) {
            return $this->initItemDescriptions();
        }
        if ('OrderItems' == $relationName) {
            return $this->initOrderItemss();
        }
    }

    /**
     * Clears out the collItemDescriptions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItemDescriptions()
     */
    public function clearItemDescriptions()
    {
        $this->collItemDescriptions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItemDescriptions collection loaded partially.
     */
    public function resetPartialItemDescriptions($v = true)
    {
        $this->collItemDescriptionsPartial = $v;
    }

    /**
     * Initializes the collItemDescriptions collection.
     *
     * By default this just sets the collItemDescriptions collection to an empty array (like clearcollItemDescriptions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItemDescriptions($overrideExisting = true)
    {
        if (null !== $this->collItemDescriptions && !$overrideExisting) {
            return;
        }
        $this->collItemDescriptions = new ObjectCollection();
        $this->collItemDescriptions->setModel('\ItemDescription');
    }

    /**
     * Gets an array of ChildItemDescription objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildItemDescription[] List of ChildItemDescription objects
     * @throws PropelException
     */
    public function getItemDescriptions($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemDescriptionsPartial && !$this->isNew();
        if (null === $this->collItemDescriptions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItemDescriptions) {
                // return empty collection
                $this->initItemDescriptions();
            } else {
                $collItemDescriptions = ChildItemDescriptionQuery::create(null, $criteria)
                    ->filterByItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemDescriptionsPartial && count($collItemDescriptions)) {
                        $this->initItemDescriptions(false);

                        foreach ($collItemDescriptions as $obj) {
                            if (false == $this->collItemDescriptions->contains($obj)) {
                                $this->collItemDescriptions->append($obj);
                            }
                        }

                        $this->collItemDescriptionsPartial = true;
                    }

                    reset($collItemDescriptions);

                    return $collItemDescriptions;
                }

                if ($partial && $this->collItemDescriptions) {
                    foreach ($this->collItemDescriptions as $obj) {
                        if ($obj->isNew()) {
                            $collItemDescriptions[] = $obj;
                        }
                    }
                }

                $this->collItemDescriptions = $collItemDescriptions;
                $this->collItemDescriptionsPartial = false;
            }
        }

        return $this->collItemDescriptions;
    }

    /**
     * Sets a collection of ItemDescription objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $itemDescriptions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildItem The current object (for fluent API support)
     */
    public function setItemDescriptions(Collection $itemDescriptions, ConnectionInterface $con = null)
    {
        $itemDescriptionsToDelete = $this->getItemDescriptions(new Criteria(), $con)->diff($itemDescriptions);


        $this->itemDescriptionsScheduledForDeletion = $itemDescriptionsToDelete;

        foreach ($itemDescriptionsToDelete as $itemDescriptionRemoved) {
            $itemDescriptionRemoved->setItem(null);
        }

        $this->collItemDescriptions = null;
        foreach ($itemDescriptions as $itemDescription) {
            $this->addItemDescription($itemDescription);
        }

        $this->collItemDescriptions = $itemDescriptions;
        $this->collItemDescriptionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ItemDescription objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ItemDescription objects.
     * @throws PropelException
     */
    public function countItemDescriptions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemDescriptionsPartial && !$this->isNew();
        if (null === $this->collItemDescriptions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItemDescriptions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItemDescriptions());
            }

            $query = ChildItemDescriptionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByItem($this)
                ->count($con);
        }

        return count($this->collItemDescriptions);
    }

    /**
     * Method called to associate a ChildItemDescription object to this object
     * through the ChildItemDescription foreign key attribute.
     *
     * @param    ChildItemDescription $l ChildItemDescription
     * @return   \Item The current object (for fluent API support)
     */
    public function addItemDescription(ChildItemDescription $l)
    {
        if ($this->collItemDescriptions === null) {
            $this->initItemDescriptions();
            $this->collItemDescriptionsPartial = true;
        }

        if (!in_array($l, $this->collItemDescriptions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddItemDescription($l);
        }

        return $this;
    }

    /**
     * @param ItemDescription $itemDescription The itemDescription object to add.
     */
    protected function doAddItemDescription($itemDescription)
    {
        $this->collItemDescriptions[]= $itemDescription;
        $itemDescription->setItem($this);
    }

    /**
     * @param  ItemDescription $itemDescription The itemDescription object to remove.
     * @return ChildItem The current object (for fluent API support)
     */
    public function removeItemDescription($itemDescription)
    {
        if ($this->getItemDescriptions()->contains($itemDescription)) {
            $this->collItemDescriptions->remove($this->collItemDescriptions->search($itemDescription));
            if (null === $this->itemDescriptionsScheduledForDeletion) {
                $this->itemDescriptionsScheduledForDeletion = clone $this->collItemDescriptions;
                $this->itemDescriptionsScheduledForDeletion->clear();
            }
            $this->itemDescriptionsScheduledForDeletion[]= clone $itemDescription;
            $itemDescription->setItem(null);
        }

        return $this;
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
     * If this ChildItem is new, it will return
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
                    ->filterByItem($this)
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
     * @return   ChildItem The current object (for fluent API support)
     */
    public function setOrderItemss(Collection $orderItemss, ConnectionInterface $con = null)
    {
        $orderItemssToDelete = $this->getOrderItemss(new Criteria(), $con)->diff($orderItemss);


        $this->orderItemssScheduledForDeletion = $orderItemssToDelete;

        foreach ($orderItemssToDelete as $orderItemsRemoved) {
            $orderItemsRemoved->setItem(null);
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
                ->filterByItem($this)
                ->count($con);
        }

        return count($this->collOrderItemss);
    }

    /**
     * Method called to associate a ChildOrderItems object to this object
     * through the ChildOrderItems foreign key attribute.
     *
     * @param    ChildOrderItems $l ChildOrderItems
     * @return   \Item The current object (for fluent API support)
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
        $orderItems->setItem($this);
    }

    /**
     * @param  OrderItems $orderItems The orderItems object to remove.
     * @return ChildItem The current object (for fluent API support)
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
            $orderItems->setItem(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Item is new, it will return
     * an empty collection; or if this Item has previously
     * been saved, it will retrieve related OrderItemss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Item.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildOrderItems[] List of ChildOrderItems objects
     */
    public function getOrderItemssJoinOrders($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildOrderItemsQuery::create(null, $criteria);
        $query->joinWith('Orders', $joinBehavior);

        return $this->getOrderItemss($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->item_id = null;
        $this->name = null;
        $this->price = null;
        $this->image = null;
        $this->available = null;
        $this->category_id = null;
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
            if ($this->collItemDescriptions) {
                foreach ($this->collItemDescriptions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOrderItemss) {
                foreach ($this->collOrderItemss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collItemDescriptions = null;
        $this->collOrderItemss = null;
        $this->aCategory = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemTableMap::DEFAULT_STRING_FORMAT);
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
