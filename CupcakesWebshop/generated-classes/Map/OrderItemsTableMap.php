<?php

namespace Map;

use \OrderItems;
use \OrderItemsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'order_items' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class OrderItemsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.OrderItemsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'bti7054';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'order_items';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\OrderItems';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'OrderItems';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the ORDER_ITEMS_ID field
     */
    const ORDER_ITEMS_ID = 'order_items.ORDER_ITEMS_ID';

    /**
     * the column name for the AMOUNT field
     */
    const AMOUNT = 'order_items.AMOUNT';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'order_items.ORDER_ID';

    /**
     * the column name for the ITEM_ID field
     */
    const ITEM_ID = 'order_items.ITEM_ID';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('OrderItemsId', 'Amount', 'OrderId', 'ItemId', ),
        self::TYPE_STUDLYPHPNAME => array('orderItemsId', 'amount', 'orderId', 'itemId', ),
        self::TYPE_COLNAME       => array(OrderItemsTableMap::ORDER_ITEMS_ID, OrderItemsTableMap::AMOUNT, OrderItemsTableMap::ORDER_ID, OrderItemsTableMap::ITEM_ID, ),
        self::TYPE_RAW_COLNAME   => array('ORDER_ITEMS_ID', 'AMOUNT', 'ORDER_ID', 'ITEM_ID', ),
        self::TYPE_FIELDNAME     => array('order_items_id', 'amount', 'order_id', 'item_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('OrderItemsId' => 0, 'Amount' => 1, 'OrderId' => 2, 'ItemId' => 3, ),
        self::TYPE_STUDLYPHPNAME => array('orderItemsId' => 0, 'amount' => 1, 'orderId' => 2, 'itemId' => 3, ),
        self::TYPE_COLNAME       => array(OrderItemsTableMap::ORDER_ITEMS_ID => 0, OrderItemsTableMap::AMOUNT => 1, OrderItemsTableMap::ORDER_ID => 2, OrderItemsTableMap::ITEM_ID => 3, ),
        self::TYPE_RAW_COLNAME   => array('ORDER_ITEMS_ID' => 0, 'AMOUNT' => 1, 'ORDER_ID' => 2, 'ITEM_ID' => 3, ),
        self::TYPE_FIELDNAME     => array('order_items_id' => 0, 'amount' => 1, 'order_id' => 2, 'item_id' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('order_items');
        $this->setPhpName('OrderItems');
        $this->setClassName('\\OrderItems');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ORDER_ITEMS_ID', 'OrderItemsId', 'INTEGER', true, null, null);
        $this->addColumn('AMOUNT', 'Amount', 'INTEGER', true, null, null);
        $this->addForeignKey('ORDER_ID', 'OrderId', 'INTEGER', 'orders', 'ORDER_ID', true, null, null);
        $this->addForeignKey('ITEM_ID', 'ItemId', 'INTEGER', 'item', 'ITEM_ID', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Item', '\\Item', RelationMap::MANY_TO_ONE, array('item_id' => 'item_id', ), null, null);
        $this->addRelation('Orders', '\\Orders', RelationMap::MANY_TO_ONE, array('order_id' => 'order_id', ), null, null);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OrderItemsId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OrderItemsId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('OrderItemsId', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? OrderItemsTableMap::CLASS_DEFAULT : OrderItemsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (OrderItems object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = OrderItemsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = OrderItemsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + OrderItemsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = OrderItemsTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            OrderItemsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = OrderItemsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = OrderItemsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                OrderItemsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(OrderItemsTableMap::ORDER_ITEMS_ID);
            $criteria->addSelectColumn(OrderItemsTableMap::AMOUNT);
            $criteria->addSelectColumn(OrderItemsTableMap::ORDER_ID);
            $criteria->addSelectColumn(OrderItemsTableMap::ITEM_ID);
        } else {
            $criteria->addSelectColumn($alias . '.ORDER_ITEMS_ID');
            $criteria->addSelectColumn($alias . '.AMOUNT');
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.ITEM_ID');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(OrderItemsTableMap::DATABASE_NAME)->getTable(OrderItemsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(OrderItemsTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(OrderItemsTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new OrderItemsTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a OrderItems or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or OrderItems object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderItemsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \OrderItems) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(OrderItemsTableMap::DATABASE_NAME);
            $criteria->add(OrderItemsTableMap::ORDER_ITEMS_ID, (array) $values, Criteria::IN);
        }

        $query = OrderItemsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { OrderItemsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { OrderItemsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the order_items table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return OrderItemsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a OrderItems or Criteria object.
     *
     * @param mixed               $criteria Criteria or OrderItems object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderItemsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from OrderItems object
        }

        if ($criteria->containsKey(OrderItemsTableMap::ORDER_ITEMS_ID) && $criteria->keyContainsValue(OrderItemsTableMap::ORDER_ITEMS_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.OrderItemsTableMap::ORDER_ITEMS_ID.')');
        }


        // Set the correct dbName
        $query = OrderItemsQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // OrderItemsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
OrderItemsTableMap::buildTableMap();
