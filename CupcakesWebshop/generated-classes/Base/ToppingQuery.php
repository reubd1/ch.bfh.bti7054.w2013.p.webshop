<?php

namespace Base;

use \Topping as ChildTopping;
use \ToppingQuery as ChildToppingQuery;
use \Exception;
use \PDO;
use Map\ToppingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'topping' table.
 *
 *
 *
 * @method     ChildToppingQuery orderByToppingId($order = Criteria::ASC) Order by the topping_id column
 * @method     ChildToppingQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildToppingQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildToppingQuery groupByToppingId() Group by the topping_id column
 * @method     ChildToppingQuery groupByName() Group by the name column
 * @method     ChildToppingQuery groupByDescription() Group by the description column
 *
 * @method     ChildToppingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildToppingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildToppingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildToppingQuery leftJoinCustomItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomItem relation
 * @method     ChildToppingQuery rightJoinCustomItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomItem relation
 * @method     ChildToppingQuery innerJoinCustomItem($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomItem relation
 *
 * @method     ChildTopping findOne(ConnectionInterface $con = null) Return the first ChildTopping matching the query
 * @method     ChildTopping findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTopping matching the query, or a new ChildTopping object populated from the query conditions when no match is found
 *
 * @method     ChildTopping findOneByToppingId(int $topping_id) Return the first ChildTopping filtered by the topping_id column
 * @method     ChildTopping findOneByName(string $name) Return the first ChildTopping filtered by the name column
 * @method     ChildTopping findOneByDescription(string $description) Return the first ChildTopping filtered by the description column
 *
 * @method     array findByToppingId(int $topping_id) Return ChildTopping objects filtered by the topping_id column
 * @method     array findByName(string $name) Return ChildTopping objects filtered by the name column
 * @method     array findByDescription(string $description) Return ChildTopping objects filtered by the description column
 *
 */
abstract class ToppingQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ToppingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'bti7054', $modelName = '\\Topping', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildToppingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildToppingQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \ToppingQuery) {
            return $criteria;
        }
        $query = new \ToppingQuery();
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
     * @return ChildTopping|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ToppingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ToppingTableMap::DATABASE_NAME);
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
     * @return   ChildTopping A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT TOPPING_ID, NAME, DESCRIPTION FROM topping WHERE TOPPING_ID = :p0';
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
            $obj = new ChildTopping();
            $obj->hydrate($row);
            ToppingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTopping|array|mixed the result, formatted by the current formatter
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
     * @return ChildToppingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ToppingTableMap::TOPPING_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildToppingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ToppingTableMap::TOPPING_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the topping_id column
     *
     * Example usage:
     * <code>
     * $query->filterByToppingId(1234); // WHERE topping_id = 1234
     * $query->filterByToppingId(array(12, 34)); // WHERE topping_id IN (12, 34)
     * $query->filterByToppingId(array('min' => 12)); // WHERE topping_id > 12
     * </code>
     *
     * @param     mixed $toppingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildToppingQuery The current query, for fluid interface
     */
    public function filterByToppingId($toppingId = null, $comparison = null)
    {
        if (is_array($toppingId)) {
            $useMinMax = false;
            if (isset($toppingId['min'])) {
                $this->addUsingAlias(ToppingTableMap::TOPPING_ID, $toppingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($toppingId['max'])) {
                $this->addUsingAlias(ToppingTableMap::TOPPING_ID, $toppingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ToppingTableMap::TOPPING_ID, $toppingId, $comparison);
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
     * @return ChildToppingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ToppingTableMap::NAME, $name, $comparison);
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
     * @return ChildToppingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ToppingTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \CustomItem object
     *
     * @param \CustomItem|ObjectCollection $customItem  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildToppingQuery The current query, for fluid interface
     */
    public function filterByCustomItem($customItem, $comparison = null)
    {
        if ($customItem instanceof \CustomItem) {
            return $this
                ->addUsingAlias(ToppingTableMap::TOPPING_ID, $customItem->getToppingId(), $comparison);
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
     * @return ChildToppingQuery The current query, for fluid interface
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
     * @param   ChildTopping $topping Object to remove from the list of results
     *
     * @return ChildToppingQuery The current query, for fluid interface
     */
    public function prune($topping = null)
    {
        if ($topping) {
            $this->addUsingAlias(ToppingTableMap::TOPPING_ID, $topping->getToppingId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the topping table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ToppingTableMap::DATABASE_NAME);
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
            ToppingTableMap::clearInstancePool();
            ToppingTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildTopping or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildTopping object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ToppingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ToppingTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ToppingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ToppingTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ToppingQuery
