<?php

namespace Base;

use \Decoration as ChildDecoration;
use \DecorationQuery as ChildDecorationQuery;
use \Exception;
use \PDO;
use Map\DecorationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'decoration' table.
 *
 *
 *
 * @method     ChildDecorationQuery orderByDecoId($order = Criteria::ASC) Order by the deco_id column
 * @method     ChildDecorationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildDecorationQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildDecorationQuery groupByDecoId() Group by the deco_id column
 * @method     ChildDecorationQuery groupByName() Group by the name column
 * @method     ChildDecorationQuery groupByDescription() Group by the description column
 *
 * @method     ChildDecorationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDecorationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDecorationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDecorationQuery leftJoinCustomItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomItem relation
 * @method     ChildDecorationQuery rightJoinCustomItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomItem relation
 * @method     ChildDecorationQuery innerJoinCustomItem($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomItem relation
 *
 * @method     ChildDecoration findOne(ConnectionInterface $con = null) Return the first ChildDecoration matching the query
 * @method     ChildDecoration findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDecoration matching the query, or a new ChildDecoration object populated from the query conditions when no match is found
 *
 * @method     ChildDecoration findOneByDecoId(int $deco_id) Return the first ChildDecoration filtered by the deco_id column
 * @method     ChildDecoration findOneByName(string $name) Return the first ChildDecoration filtered by the name column
 * @method     ChildDecoration findOneByDescription(string $description) Return the first ChildDecoration filtered by the description column
 *
 * @method     array findByDecoId(int $deco_id) Return ChildDecoration objects filtered by the deco_id column
 * @method     array findByName(string $name) Return ChildDecoration objects filtered by the name column
 * @method     array findByDescription(string $description) Return ChildDecoration objects filtered by the description column
 *
 */
abstract class DecorationQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\DecorationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'bti7054', $modelName = '\\Decoration', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDecorationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDecorationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \DecorationQuery) {
            return $criteria;
        }
        $query = new \DecorationQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDecoration|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DecorationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DecorationTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildDecoration A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT DECO_ID, NAME, DESCRIPTION FROM decoration WHERE DECO_ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildDecoration();
            $obj->hydrate($row);
            DecorationTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDecoration|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildDecorationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DecorationTableMap::DECO_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildDecorationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DecorationTableMap::DECO_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the deco_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDecoId(1234); // WHERE deco_id = 1234
     * $query->filterByDecoId(array(12, 34)); // WHERE deco_id IN (12, 34)
     * $query->filterByDecoId(array('min' => 12)); // WHERE deco_id > 12
     * </code>
     *
     * @param     mixed $decoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDecorationQuery The current query, for fluid interface
     */
    public function filterByDecoId($decoId = null, $comparison = null)
    {
        if (is_array($decoId)) {
            $useMinMax = false;
            if (isset($decoId['min'])) {
                $this->addUsingAlias(DecorationTableMap::DECO_ID, $decoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($decoId['max'])) {
                $this->addUsingAlias(DecorationTableMap::DECO_ID, $decoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DecorationTableMap::DECO_ID, $decoId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDecorationQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DecorationTableMap::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDecorationQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DecorationTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \CustomItem object
     *
     * @param \CustomItem|ObjectCollection $customItem  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDecorationQuery The current query, for fluid interface
     */
    public function filterByCustomItem($customItem, $comparison = null)
    {
        if ($customItem instanceof \CustomItem) {
            return $this
                ->addUsingAlias(DecorationTableMap::DECO_ID, $customItem->getDecoId(), $comparison);
        } elseif ($customItem instanceof ObjectCollection) {
            return $this
                ->useCustomItemQuery()
                ->filterByPrimaryKeys($customItem->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCustomItem() only accepts arguments of type \CustomItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildDecorationQuery The current query, for fluid interface
     */
    public function joinCustomItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomItem');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CustomItem');
        }

        return $this;
    }

    /**
     * Use the CustomItem relation CustomItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CustomItemQuery A secondary query class using the current class as primary query
     */
    public function useCustomItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomItem', '\CustomItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDecoration $decoration Object to remove from the list of results
     *
     * @return ChildDecorationQuery The current query, for fluid interface
     */
    public function prune($decoration = null)
    {
        if ($decoration) {
            $this->addUsingAlias(DecorationTableMap::DECO_ID, $decoration->getDecoId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the decoration table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DecorationTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DecorationTableMap::clearInstancePool();
            DecorationTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildDecoration or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildDecoration object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DecorationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DecorationTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        DecorationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DecorationTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // DecorationQuery
