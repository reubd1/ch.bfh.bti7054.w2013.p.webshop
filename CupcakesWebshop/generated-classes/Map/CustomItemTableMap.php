<?php

namespace Map;

use \CustomItem;
use \CustomItemQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'custom_item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CustomItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CustomItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'bti7054';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'custom_item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CustomItem';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CustomItem';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the CUSTOM_ITEM_ID field
     */
    const CUSTOM_ITEM_ID = 'custom_item.CUSTOM_ITEM_ID';

    /**
     * the column name for the NAME field
     */
    const NAME = 'custom_item.NAME';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'custom_item.ORDER_ID';

    /**
     * the column name for the CAKE_ID field
     */
    const CAKE_ID = 'custom_item.CAKE_ID';

    /**
     * the column name for the TOPPING_ID field
     */
    const TOPPING_ID = 'custom_item.TOPPING_ID';

    /**
     * the column name for the DECO_ID field
     */
    const DECO_ID = 'custom_item.DECO_ID';

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
        self::TYPE_PHPNAME       => array('CustomItemId', 'Name', 'OrderId', 'CakeId', 'ToppingId', 'DecoId', ),
        self::TYPE_STUDLYPHPNAME => array('customItemId', 'name', 'orderId', 'cakeId', 'toppingId', 'decoId', ),
        self::TYPE_COLNAME       => array(CustomItemTableMap::CUSTOM_ITEM_ID, CustomItemTableMap::NAME, CustomItemTableMap::ORDER_ID, CustomItemTableMap::CAKE_ID, CustomItemTableMap::TOPPING_ID, CustomItemTableMap::DECO_ID, ),
        self::TYPE_RAW_COLNAME   => array('CUSTOM_ITEM_ID', 'NAME', 'ORDER_ID', 'CAKE_ID', 'TOPPING_ID', 'DECO_ID', ),
        self::TYPE_FIELDNAME     => array('custom_item_id', 'name', 'order_id', 'cake_id', 'topping_id', 'deco_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('CustomItemId' => 0, 'Name' => 1, 'OrderId' => 2, 'CakeId' => 3, 'ToppingId' => 4, 'DecoId' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('customItemId' => 0, 'name' => 1, 'orderId' => 2, 'cakeId' => 3, 'toppingId' => 4, 'decoId' => 5, ),
        self::TYPE_COLNAME       => array(CustomItemTableMap::CUSTOM_ITEM_ID => 0, CustomItemTableMap::NAME => 1, CustomItemTableMap::ORDER_ID => 2, CustomItemTableMap::CAKE_ID => 3, CustomItemTableMap::TOPPING_ID => 4, CustomItemTableMap::DECO_ID => 5, ),
        self::TYPE_RAW_COLNAME   => array('CUSTOM_ITEM_ID' => 0, 'NAME' => 1, 'ORDER_ID' => 2, 'CAKE_ID' => 3, 'TOPPING_ID' => 4, 'DECO_ID' => 5, ),
        self::TYPE_FIELDNAME     => array('custom_item_id' => 0, 'name' => 1, 'order_id' => 2, 'cake_id' => 3, 'topping_id' => 4, 'deco_id' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('custom_item');
        $this->setPhpName('CustomItem');
        $this->setClassName('\\CustomItem');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('CUSTOM_ITEM_ID', 'CustomItemId', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 45, null);
        $this->addForeignKey('ORDER_ID', 'OrderId', 'INTEGER', 'order', 'ORDER_ID', true, null, null);
        $this->addForeignKey('CAKE_ID', 'CakeId', 'INTEGER', 'cake', 'CAKE_ID', true, null, null);
        $this->addForeignKey('TOPPING_ID', 'ToppingId', 'INTEGER', 'topping', 'TOPPING_ID', true, null, null);
        $this->addForeignKey('DECO_ID', 'DecoId', 'INTEGER', 'decoration', 'DECO_ID', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Order', '\\Order', RelationMap::MANY_TO_ONE, array('order_id' => 'order_id', ), null, null);
        $this->addRelation('Cake', '\\Cake', RelationMap::MANY_TO_ONE, array('cake_id' => 'cake_id', ), null, null);
        $this->addRelation('Topping', '\\Topping', RelationMap::MANY_TO_ONE, array('topping_id' => 'topping_id', ), null, null);
        $this->addRelation('Decoration', '\\Decoration', RelationMap::MANY_TO_ONE, array('deco_id' => 'deco_id', ), null, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CustomItemId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CustomItemId', TableMap::TYPE_PHPNAME, $indexType)];
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
                            : self::translateFieldName('CustomItemId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? CustomItemTableMap::CLASS_DEFAULT : CustomItemTableMap::OM_CLASS;
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
     * @return array (CustomItem object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CustomItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CustomItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CustomItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CustomItemTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CustomItemTableMap::addInstanceToPool($obj, $key);
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
            $key = CustomItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CustomItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CustomItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CustomItemTableMap::CUSTOM_ITEM_ID);
            $criteria->addSelectColumn(CustomItemTableMap::NAME);
            $criteria->addSelectColumn(CustomItemTableMap::ORDER_ID);
            $criteria->addSelectColumn(CustomItemTableMap::CAKE_ID);
            $criteria->addSelectColumn(CustomItemTableMap::TOPPING_ID);
            $criteria->addSelectColumn(CustomItemTableMap::DECO_ID);
        } else {
            $criteria->addSelectColumn($alias . '.CUSTOM_ITEM_ID');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.CAKE_ID');
            $criteria->addSelectColumn($alias . '.TOPPING_ID');
            $criteria->addSelectColumn($alias . '.DECO_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(CustomItemTableMap::DATABASE_NAME)->getTable(CustomItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(CustomItemTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(CustomItemTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new CustomItemTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a CustomItem or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CustomItem object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CustomItem) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CustomItemTableMap::DATABASE_NAME);
            $criteria->add(CustomItemTableMap::CUSTOM_ITEM_ID, (array) $values, Criteria::IN);
        }

        $query = CustomItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { CustomItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { CustomItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the custom_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CustomItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CustomItem or Criteria object.
     *
     * @param mixed               $criteria Criteria or CustomItem object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CustomItem object
        }

        if ($criteria->containsKey(CustomItemTableMap::CUSTOM_ITEM_ID) && $criteria->keyContainsValue(CustomItemTableMap::CUSTOM_ITEM_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CustomItemTableMap::CUSTOM_ITEM_ID.')');
        }


        // Set the correct dbName
        $query = CustomItemQuery::create()->mergeWith($criteria);

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

} // CustomItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CustomItemTableMap::buildTableMap();
