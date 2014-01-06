<?php

namespace Map;

use \ShippingAddress;
use \ShippingAddressQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'shipping_address' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ShippingAddressTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ShippingAddressTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'bti7054';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'shipping_address';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ShippingAddress';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ShippingAddress';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the SHIPPING_ID field
     */
    const SHIPPING_ID = 'shipping_address.SHIPPING_ID';

    /**
     * the column name for the NAME field
     */
    const NAME = 'shipping_address.NAME';

    /**
     * the column name for the STREET field
     */
    const STREET = 'shipping_address.STREET';

    /**
     * the column name for the ZIP field
     */
    const ZIP = 'shipping_address.ZIP';

    /**
     * the column name for the CITY field
     */
    const CITY = 'shipping_address.CITY';

    /**
     * the column name for the COUNTRY field
     */
    const COUNTRY = 'shipping_address.COUNTRY';

    /**
     * the column name for the AVAILABLE field
     */
    const AVAILABLE = 'shipping_address.AVAILABLE';

    /**
     * the column name for the USER_ID field
     */
    const USER_ID = 'shipping_address.USER_ID';

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
        self::TYPE_PHPNAME       => array('ShippingId', 'Name', 'Street', 'Zip', 'City', 'Country', 'Available', 'UserId', ),
        self::TYPE_STUDLYPHPNAME => array('shippingId', 'name', 'street', 'zip', 'city', 'country', 'available', 'userId', ),
        self::TYPE_COLNAME       => array(ShippingAddressTableMap::SHIPPING_ID, ShippingAddressTableMap::NAME, ShippingAddressTableMap::STREET, ShippingAddressTableMap::ZIP, ShippingAddressTableMap::CITY, ShippingAddressTableMap::COUNTRY, ShippingAddressTableMap::AVAILABLE, ShippingAddressTableMap::USER_ID, ),
        self::TYPE_RAW_COLNAME   => array('SHIPPING_ID', 'NAME', 'STREET', 'ZIP', 'CITY', 'COUNTRY', 'AVAILABLE', 'USER_ID', ),
        self::TYPE_FIELDNAME     => array('shipping_id', 'name', 'street', 'zip', 'city', 'country', 'available', 'user_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ShippingId' => 0, 'Name' => 1, 'Street' => 2, 'Zip' => 3, 'City' => 4, 'Country' => 5, 'Available' => 6, 'UserId' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('shippingId' => 0, 'name' => 1, 'street' => 2, 'zip' => 3, 'city' => 4, 'country' => 5, 'available' => 6, 'userId' => 7, ),
        self::TYPE_COLNAME       => array(ShippingAddressTableMap::SHIPPING_ID => 0, ShippingAddressTableMap::NAME => 1, ShippingAddressTableMap::STREET => 2, ShippingAddressTableMap::ZIP => 3, ShippingAddressTableMap::CITY => 4, ShippingAddressTableMap::COUNTRY => 5, ShippingAddressTableMap::AVAILABLE => 6, ShippingAddressTableMap::USER_ID => 7, ),
        self::TYPE_RAW_COLNAME   => array('SHIPPING_ID' => 0, 'NAME' => 1, 'STREET' => 2, 'ZIP' => 3, 'CITY' => 4, 'COUNTRY' => 5, 'AVAILABLE' => 6, 'USER_ID' => 7, ),
        self::TYPE_FIELDNAME     => array('shipping_id' => 0, 'name' => 1, 'street' => 2, 'zip' => 3, 'city' => 4, 'country' => 5, 'available' => 6, 'user_id' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('shipping_address');
        $this->setPhpName('ShippingAddress');
        $this->setClassName('\\ShippingAddress');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('SHIPPING_ID', 'ShippingId', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 45, null);
        $this->addColumn('STREET', 'Street', 'VARCHAR', true, 45, null);
        $this->addColumn('ZIP', 'Zip', 'INTEGER', true, null, null);
        $this->addColumn('CITY', 'City', 'VARCHAR', true, 45, null);
        $this->addColumn('COUNTRY', 'Country', 'VARCHAR', true, 45, null);
        $this->addColumn('AVAILABLE', 'Available', 'BOOLEAN', false, 1, null);
        $this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'USER_ID', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'user_id', ), null, null);
        $this->addRelation('Orders', '\\Orders', RelationMap::ONE_TO_MANY, array('shipping_id' => 'shipping_id', ), null, null, 'Orderss');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ShippingId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ShippingId', TableMap::TYPE_PHPNAME, $indexType)];
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
                            : self::translateFieldName('ShippingId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ShippingAddressTableMap::CLASS_DEFAULT : ShippingAddressTableMap::OM_CLASS;
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
     * @return array (ShippingAddress object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ShippingAddressTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ShippingAddressTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ShippingAddressTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ShippingAddressTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ShippingAddressTableMap::addInstanceToPool($obj, $key);
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
            $key = ShippingAddressTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ShippingAddressTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ShippingAddressTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ShippingAddressTableMap::SHIPPING_ID);
            $criteria->addSelectColumn(ShippingAddressTableMap::NAME);
            $criteria->addSelectColumn(ShippingAddressTableMap::STREET);
            $criteria->addSelectColumn(ShippingAddressTableMap::ZIP);
            $criteria->addSelectColumn(ShippingAddressTableMap::CITY);
            $criteria->addSelectColumn(ShippingAddressTableMap::COUNTRY);
            $criteria->addSelectColumn(ShippingAddressTableMap::AVAILABLE);
            $criteria->addSelectColumn(ShippingAddressTableMap::USER_ID);
        } else {
            $criteria->addSelectColumn($alias . '.SHIPPING_ID');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.STREET');
            $criteria->addSelectColumn($alias . '.ZIP');
            $criteria->addSelectColumn($alias . '.CITY');
            $criteria->addSelectColumn($alias . '.COUNTRY');
            $criteria->addSelectColumn($alias . '.AVAILABLE');
            $criteria->addSelectColumn($alias . '.USER_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(ShippingAddressTableMap::DATABASE_NAME)->getTable(ShippingAddressTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ShippingAddressTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ShippingAddressTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ShippingAddressTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a ShippingAddress or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ShippingAddress object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ShippingAddressTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ShippingAddress) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ShippingAddressTableMap::DATABASE_NAME);
            $criteria->add(ShippingAddressTableMap::SHIPPING_ID, (array) $values, Criteria::IN);
        }

        $query = ShippingAddressQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ShippingAddressTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ShippingAddressTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the shipping_address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ShippingAddressQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ShippingAddress or Criteria object.
     *
     * @param mixed               $criteria Criteria or ShippingAddress object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShippingAddressTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ShippingAddress object
        }

        if ($criteria->containsKey(ShippingAddressTableMap::SHIPPING_ID) && $criteria->keyContainsValue(ShippingAddressTableMap::SHIPPING_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ShippingAddressTableMap::SHIPPING_ID.')');
        }


        // Set the correct dbName
        $query = ShippingAddressQuery::create()->mergeWith($criteria);

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

} // ShippingAddressTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ShippingAddressTableMap::buildTableMap();
