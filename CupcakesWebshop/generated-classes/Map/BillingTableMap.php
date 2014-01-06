<?php

namespace Map;

use \Billing;
use \BillingQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'billing' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BillingTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.BillingTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'bti7054';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'billing';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Billing';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Billing';

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
     * the column name for the BILLING_ID field
     */
    const BILLING_ID = 'billing.BILLING_ID';

    /**
     * the column name for the USER_ID field
     */
    const USER_ID = 'billing.USER_ID';

    /**
     * the column name for the CARD_ID field
     */
    const CARD_ID = 'billing.CARD_ID';

    /**
     * the column name for the CARD_TYPE field
     */
    const CARD_TYPE = 'billing.CARD_TYPE';

    /**
     * the column name for the CARD_NUMBER field
     */
    const CARD_NUMBER = 'billing.CARD_NUMBER';

    /**
     * the column name for the EXPIRE_DATE field
     */
    const EXPIRE_DATE = 'billing.EXPIRE_DATE';

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
        self::TYPE_PHPNAME       => array('BillingId', 'UserId', 'CardId', 'CardType', 'CardNumber', 'ExpireDate', ),
        self::TYPE_STUDLYPHPNAME => array('billingId', 'userId', 'cardId', 'cardType', 'cardNumber', 'expireDate', ),
        self::TYPE_COLNAME       => array(BillingTableMap::BILLING_ID, BillingTableMap::USER_ID, BillingTableMap::CARD_ID, BillingTableMap::CARD_TYPE, BillingTableMap::CARD_NUMBER, BillingTableMap::EXPIRE_DATE, ),
        self::TYPE_RAW_COLNAME   => array('BILLING_ID', 'USER_ID', 'CARD_ID', 'CARD_TYPE', 'CARD_NUMBER', 'EXPIRE_DATE', ),
        self::TYPE_FIELDNAME     => array('billing_id', 'user_id', 'card_id', 'card_type', 'card_number', 'expire_date', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('BillingId' => 0, 'UserId' => 1, 'CardId' => 2, 'CardType' => 3, 'CardNumber' => 4, 'ExpireDate' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('billingId' => 0, 'userId' => 1, 'cardId' => 2, 'cardType' => 3, 'cardNumber' => 4, 'expireDate' => 5, ),
        self::TYPE_COLNAME       => array(BillingTableMap::BILLING_ID => 0, BillingTableMap::USER_ID => 1, BillingTableMap::CARD_ID => 2, BillingTableMap::CARD_TYPE => 3, BillingTableMap::CARD_NUMBER => 4, BillingTableMap::EXPIRE_DATE => 5, ),
        self::TYPE_RAW_COLNAME   => array('BILLING_ID' => 0, 'USER_ID' => 1, 'CARD_ID' => 2, 'CARD_TYPE' => 3, 'CARD_NUMBER' => 4, 'EXPIRE_DATE' => 5, ),
        self::TYPE_FIELDNAME     => array('billing_id' => 0, 'user_id' => 1, 'card_id' => 2, 'card_type' => 3, 'card_number' => 4, 'expire_date' => 5, ),
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
        $this->setName('billing');
        $this->setPhpName('Billing');
        $this->setClassName('\\Billing');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('BILLING_ID', 'BillingId', 'INTEGER', true, null, null);
        $this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'USER_ID', true, null, null);
        $this->addColumn('CARD_ID', 'CardId', 'INTEGER', true, null, null);
        $this->addColumn('CARD_TYPE', 'CardType', 'INTEGER', true, null, null);
        $this->addColumn('CARD_NUMBER', 'CardNumber', 'INTEGER', true, null, null);
        $this->addColumn('EXPIRE_DATE', 'ExpireDate', 'DATE', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'user_id', ), null, null);
        $this->addRelation('Orders', '\\Orders', RelationMap::ONE_TO_MANY, array('billing_id' => 'billing_id', ), null, null, 'Orderss');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BillingId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BillingId', TableMap::TYPE_PHPNAME, $indexType)];
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
                            : self::translateFieldName('BillingId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? BillingTableMap::CLASS_DEFAULT : BillingTableMap::OM_CLASS;
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
     * @return array (Billing object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BillingTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BillingTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BillingTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BillingTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BillingTableMap::addInstanceToPool($obj, $key);
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
            $key = BillingTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BillingTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BillingTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BillingTableMap::BILLING_ID);
            $criteria->addSelectColumn(BillingTableMap::USER_ID);
            $criteria->addSelectColumn(BillingTableMap::CARD_ID);
            $criteria->addSelectColumn(BillingTableMap::CARD_TYPE);
            $criteria->addSelectColumn(BillingTableMap::CARD_NUMBER);
            $criteria->addSelectColumn(BillingTableMap::EXPIRE_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.BILLING_ID');
            $criteria->addSelectColumn($alias . '.USER_ID');
            $criteria->addSelectColumn($alias . '.CARD_ID');
            $criteria->addSelectColumn($alias . '.CARD_TYPE');
            $criteria->addSelectColumn($alias . '.CARD_NUMBER');
            $criteria->addSelectColumn($alias . '.EXPIRE_DATE');
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
        return Propel::getServiceContainer()->getDatabaseMap(BillingTableMap::DATABASE_NAME)->getTable(BillingTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(BillingTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(BillingTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new BillingTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Billing or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Billing object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BillingTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Billing) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BillingTableMap::DATABASE_NAME);
            $criteria->add(BillingTableMap::BILLING_ID, (array) $values, Criteria::IN);
        }

        $query = BillingQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { BillingTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { BillingTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the billing table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BillingQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Billing or Criteria object.
     *
     * @param mixed               $criteria Criteria or Billing object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BillingTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Billing object
        }

        if ($criteria->containsKey(BillingTableMap::BILLING_ID) && $criteria->keyContainsValue(BillingTableMap::BILLING_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BillingTableMap::BILLING_ID.')');
        }


        // Set the correct dbName
        $query = BillingQuery::create()->mergeWith($criteria);

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

} // BillingTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BillingTableMap::buildTableMap();
