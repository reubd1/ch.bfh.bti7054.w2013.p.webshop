<?php

namespace Base;

use \Billing as ChildBilling;
use \BillingQuery as ChildBillingQuery;
use \Exception;
use \PDO;
use Map\BillingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'billing' table.
 *
 *
 *
 * @method     ChildBillingQuery orderByBillingId($order = Criteria::ASC) Order by the billing_id column
 * @method     ChildBillingQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildBillingQuery orderByCardId($order = Criteria::ASC) Order by the card_id column
 * @method     ChildBillingQuery orderByCardType($order = Criteria::ASC) Order by the card_type column
 * @method     ChildBillingQuery orderByCardNumber($order = Criteria::ASC) Order by the card_number column
 * @method     ChildBillingQuery orderByExpireDate($order = Criteria::ASC) Order by the expire_date column
 *
 * @method     ChildBillingQuery groupByBillingId() Group by the billing_id column
 * @method     ChildBillingQuery groupByUserId() Group by the user_id column
 * @method     ChildBillingQuery groupByCardId() Group by the card_id column
 * @method     ChildBillingQuery groupByCardType() Group by the card_type column
 * @method     ChildBillingQuery groupByCardNumber() Group by the card_number column
 * @method     ChildBillingQuery groupByExpireDate() Group by the expire_date column
 *
 * @method     ChildBillingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBillingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBillingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBillingQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildBillingQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildBillingQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildBillingQuery leftJoinOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the Orders relation
 * @method     ChildBillingQuery rightJoinOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Orders relation
 * @method     ChildBillingQuery innerJoinOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the Orders relation
 *
 * @method     ChildBilling findOne(ConnectionInterface $con = null) Return the first ChildBilling matching the query
 * @method     ChildBilling findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBilling matching the query, or a new ChildBilling object populated from the query conditions when no match is found
 *
 * @method     ChildBilling findOneByBillingId(int $billing_id) Return the first ChildBilling filtered by the billing_id column
 * @method     ChildBilling findOneByUserId(int $user_id) Return the first ChildBilling filtered by the user_id column
 * @method     ChildBilling findOneByCardId(int $card_id) Return the first ChildBilling filtered by the card_id column
 * @method     ChildBilling findOneByCardType(int $card_type) Return the first ChildBilling filtered by the card_type column
 * @method     ChildBilling findOneByCardNumber(int $card_number) Return the first ChildBilling filtered by the card_number column
 * @method     ChildBilling findOneByExpireDate(string $expire_date) Return the first ChildBilling filtered by the expire_date column
 *
 * @method     array findByBillingId(int $billing_id) Return ChildBilling objects filtered by the billing_id column
 * @method     array findByUserId(int $user_id) Return ChildBilling objects filtered by the user_id column
 * @method     array findByCardId(int $card_id) Return ChildBilling objects filtered by the card_id column
 * @method     array findByCardType(int $card_type) Return ChildBilling objects filtered by the card_type column
 * @method     array findByCardNumber(int $card_number) Return ChildBilling objects filtered by the card_number column
 * @method     array findByExpireDate(string $expire_date) Return ChildBilling objects filtered by the expire_date column
 *
 */
abstract class BillingQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\BillingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'bti7054', $modelName = '\\Billing', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBillingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBillingQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \BillingQuery) {
            return $criteria;
        }
        $query = new \BillingQuery();
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
     * @return ChildBilling|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BillingTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BillingTableMap::DATABASE_NAME);
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
     * @return   ChildBilling A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT BILLING_ID, USER_ID, CARD_ID, CARD_TYPE, CARD_NUMBER, EXPIRE_DATE FROM billing WHERE BILLING_ID = :p0';
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
            $obj = new ChildBilling();
            $obj->hydrate($row);
            BillingTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildBilling|array|mixed the result, formatted by the current formatter
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
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BillingTableMap::BILLING_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BillingTableMap::BILLING_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the billing_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBillingId(1234); // WHERE billing_id = 1234
     * $query->filterByBillingId(array(12, 34)); // WHERE billing_id IN (12, 34)
     * $query->filterByBillingId(array('min' => 12)); // WHERE billing_id > 12
     * </code>
     *
     * @param     mixed $billingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByBillingId($billingId = null, $comparison = null)
    {
        if (is_array($billingId)) {
            $useMinMax = false;
            if (isset($billingId['min'])) {
                $this->addUsingAlias(BillingTableMap::BILLING_ID, $billingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($billingId['max'])) {
                $this->addUsingAlias(BillingTableMap::BILLING_ID, $billingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillingTableMap::BILLING_ID, $billingId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(BillingTableMap::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(BillingTableMap::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillingTableMap::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the card_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCardId(1234); // WHERE card_id = 1234
     * $query->filterByCardId(array(12, 34)); // WHERE card_id IN (12, 34)
     * $query->filterByCardId(array('min' => 12)); // WHERE card_id > 12
     * </code>
     *
     * @param     mixed $cardId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByCardId($cardId = null, $comparison = null)
    {
        if (is_array($cardId)) {
            $useMinMax = false;
            if (isset($cardId['min'])) {
                $this->addUsingAlias(BillingTableMap::CARD_ID, $cardId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardId['max'])) {
                $this->addUsingAlias(BillingTableMap::CARD_ID, $cardId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillingTableMap::CARD_ID, $cardId, $comparison);
    }

    /**
     * Filter the query on the card_type column
     *
     * Example usage:
     * <code>
     * $query->filterByCardType(1234); // WHERE card_type = 1234
     * $query->filterByCardType(array(12, 34)); // WHERE card_type IN (12, 34)
     * $query->filterByCardType(array('min' => 12)); // WHERE card_type > 12
     * </code>
     *
     * @param     mixed $cardType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByCardType($cardType = null, $comparison = null)
    {
        if (is_array($cardType)) {
            $useMinMax = false;
            if (isset($cardType['min'])) {
                $this->addUsingAlias(BillingTableMap::CARD_TYPE, $cardType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardType['max'])) {
                $this->addUsingAlias(BillingTableMap::CARD_TYPE, $cardType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillingTableMap::CARD_TYPE, $cardType, $comparison);
    }

    /**
     * Filter the query on the card_number column
     *
     * Example usage:
     * <code>
     * $query->filterByCardNumber(1234); // WHERE card_number = 1234
     * $query->filterByCardNumber(array(12, 34)); // WHERE card_number IN (12, 34)
     * $query->filterByCardNumber(array('min' => 12)); // WHERE card_number > 12
     * </code>
     *
     * @param     mixed $cardNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByCardNumber($cardNumber = null, $comparison = null)
    {
        if (is_array($cardNumber)) {
            $useMinMax = false;
            if (isset($cardNumber['min'])) {
                $this->addUsingAlias(BillingTableMap::CARD_NUMBER, $cardNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardNumber['max'])) {
                $this->addUsingAlias(BillingTableMap::CARD_NUMBER, $cardNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillingTableMap::CARD_NUMBER, $cardNumber, $comparison);
    }

    /**
     * Filter the query on the expire_date column
     *
     * Example usage:
     * <code>
     * $query->filterByExpireDate('2011-03-14'); // WHERE expire_date = '2011-03-14'
     * $query->filterByExpireDate('now'); // WHERE expire_date = '2011-03-14'
     * $query->filterByExpireDate(array('max' => 'yesterday')); // WHERE expire_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $expireDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByExpireDate($expireDate = null, $comparison = null)
    {
        if (is_array($expireDate)) {
            $useMinMax = false;
            if (isset($expireDate['min'])) {
                $this->addUsingAlias(BillingTableMap::EXPIRE_DATE, $expireDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expireDate['max'])) {
                $this->addUsingAlias(BillingTableMap::EXPIRE_DATE, $expireDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BillingTableMap::EXPIRE_DATE, $expireDate, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(BillingTableMap::USER_ID, $user->getUserId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BillingTableMap::USER_ID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Filter the query by a related \Orders object
     *
     * @param \Orders|ObjectCollection $orders  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function filterByOrders($orders, $comparison = null)
    {
        if ($orders instanceof \Orders) {
            return $this
                ->addUsingAlias(BillingTableMap::BILLING_ID, $orders->getBillingId(), $comparison);
        } elseif ($orders instanceof ObjectCollection) {
            return $this
                ->useOrdersQuery()
                ->filterByPrimaryKeys($orders->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrders() only accepts arguments of type \Orders or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Orders relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function joinOrders($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Orders');

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
            $this->addJoinObject($join, 'Orders');
        }

        return $this;
    }

    /**
     * Use the Orders relation Orders object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \OrdersQuery A secondary query class using the current class as primary query
     */
    public function useOrdersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrders($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Orders', '\OrdersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBilling $billing Object to remove from the list of results
     *
     * @return ChildBillingQuery The current query, for fluid interface
     */
    public function prune($billing = null)
    {
        if ($billing) {
            $this->addUsingAlias(BillingTableMap::BILLING_ID, $billing->getBillingId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the billing table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BillingTableMap::DATABASE_NAME);
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
            BillingTableMap::clearInstancePool();
            BillingTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildBilling or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildBilling object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BillingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BillingTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        BillingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BillingTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // BillingQuery
