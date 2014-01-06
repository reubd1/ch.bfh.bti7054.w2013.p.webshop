<?php

namespace Base;

use \Orders as ChildOrders;
use \OrdersQuery as ChildOrdersQuery;
use \Exception;
use \PDO;
use Map\OrdersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'orders' table.
 *
 *
 *
 * @method     ChildOrdersQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOrdersQuery orderByTotal($order = Criteria::ASC) Order by the total column
 * @method     ChildOrdersQuery orderByOrderDate($order = Criteria::ASC) Order by the order_date column
 * @method     ChildOrdersQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildOrdersQuery orderByShippingId($order = Criteria::ASC) Order by the shipping_id column
 * @method     ChildOrdersQuery orderByBillingId($order = Criteria::ASC) Order by the billing_id column
 *
 * @method     ChildOrdersQuery groupByOrderId() Group by the order_id column
 * @method     ChildOrdersQuery groupByTotal() Group by the total column
 * @method     ChildOrdersQuery groupByOrderDate() Group by the order_date column
 * @method     ChildOrdersQuery groupByUserId() Group by the user_id column
 * @method     ChildOrdersQuery groupByShippingId() Group by the shipping_id column
 * @method     ChildOrdersQuery groupByBillingId() Group by the billing_id column
 *
 * @method     ChildOrdersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrdersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrdersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrdersQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildOrdersQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildOrdersQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildOrdersQuery leftJoinBilling($relationAlias = null) Adds a LEFT JOIN clause to the query using the Billing relation
 * @method     ChildOrdersQuery rightJoinBilling($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Billing relation
 * @method     ChildOrdersQuery innerJoinBilling($relationAlias = null) Adds a INNER JOIN clause to the query using the Billing relation
 *
 * @method     ChildOrdersQuery leftJoinShippingAddress($relationAlias = null) Adds a LEFT JOIN clause to the query using the ShippingAddress relation
 * @method     ChildOrdersQuery rightJoinShippingAddress($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ShippingAddress relation
 * @method     ChildOrdersQuery innerJoinShippingAddress($relationAlias = null) Adds a INNER JOIN clause to the query using the ShippingAddress relation
 *
 * @method     ChildOrdersQuery leftJoinOrderItems($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderItems relation
 * @method     ChildOrdersQuery rightJoinOrderItems($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderItems relation
 * @method     ChildOrdersQuery innerJoinOrderItems($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderItems relation
 *
 * @method     ChildOrdersQuery leftJoinCustomItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomItem relation
 * @method     ChildOrdersQuery rightJoinCustomItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomItem relation
 * @method     ChildOrdersQuery innerJoinCustomItem($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomItem relation
 *
 * @method     ChildOrders findOne(ConnectionInterface $con = null) Return the first ChildOrders matching the query
 * @method     ChildOrders findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrders matching the query, or a new ChildOrders object populated from the query conditions when no match is found
 *
 * @method     ChildOrders findOneByOrderId(int $order_id) Return the first ChildOrders filtered by the order_id column
 * @method     ChildOrders findOneByTotal(double $total) Return the first ChildOrders filtered by the total column
 * @method     ChildOrders findOneByOrderDate(string $order_date) Return the first ChildOrders filtered by the order_date column
 * @method     ChildOrders findOneByUserId(int $user_id) Return the first ChildOrders filtered by the user_id column
 * @method     ChildOrders findOneByShippingId(int $shipping_id) Return the first ChildOrders filtered by the shipping_id column
 * @method     ChildOrders findOneByBillingId(int $billing_id) Return the first ChildOrders filtered by the billing_id column
 *
 * @method     array findByOrderId(int $order_id) Return ChildOrders objects filtered by the order_id column
 * @method     array findByTotal(double $total) Return ChildOrders objects filtered by the total column
 * @method     array findByOrderDate(string $order_date) Return ChildOrders objects filtered by the order_date column
 * @method     array findByUserId(int $user_id) Return ChildOrders objects filtered by the user_id column
 * @method     array findByShippingId(int $shipping_id) Return ChildOrders objects filtered by the shipping_id column
 * @method     array findByBillingId(int $billing_id) Return ChildOrders objects filtered by the billing_id column
 *
 */
abstract class OrdersQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\OrdersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'bti7054', $modelName = '\\Orders', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrdersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrdersQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \OrdersQuery) {
            return $criteria;
        }
        $query = new \OrdersQuery();
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
     * @return ChildOrders|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrdersTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrdersTableMap::DATABASE_NAME);
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
     * @return   ChildOrders A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ORDER_ID, TOTAL, ORDER_DATE, USER_ID, SHIPPING_ID, BILLING_ID FROM orders WHERE ORDER_ID = :p0';
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
            $obj = new ChildOrders();
            $obj->hydrate($row);
            OrdersTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildOrders|array|mixed the result, formatted by the current formatter
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
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrdersTableMap::ORDER_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrdersTableMap::ORDER_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(OrdersTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(OrdersTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total > 12
     * </code>
     *
     * @param     mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(OrdersTableMap::TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(OrdersTableMap::TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::TOTAL, $total, $comparison);
    }

    /**
     * Filter the query on the order_date column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderDate('2011-03-14'); // WHERE order_date = '2011-03-14'
     * $query->filterByOrderDate('now'); // WHERE order_date = '2011-03-14'
     * $query->filterByOrderDate(array('max' => 'yesterday')); // WHERE order_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $orderDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderDate($orderDate = null, $comparison = null)
    {
        if (is_array($orderDate)) {
            $useMinMax = false;
            if (isset($orderDate['min'])) {
                $this->addUsingAlias(OrdersTableMap::ORDER_DATE, $orderDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderDate['max'])) {
                $this->addUsingAlias(OrdersTableMap::ORDER_DATE, $orderDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::ORDER_DATE, $orderDate, $comparison);
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
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(OrdersTableMap::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(OrdersTableMap::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the shipping_id column
     *
     * Example usage:
     * <code>
     * $query->filterByShippingId(1234); // WHERE shipping_id = 1234
     * $query->filterByShippingId(array(12, 34)); // WHERE shipping_id IN (12, 34)
     * $query->filterByShippingId(array('min' => 12)); // WHERE shipping_id > 12
     * </code>
     *
     * @see       filterByShippingAddress()
     *
     * @param     mixed $shippingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByShippingId($shippingId = null, $comparison = null)
    {
        if (is_array($shippingId)) {
            $useMinMax = false;
            if (isset($shippingId['min'])) {
                $this->addUsingAlias(OrdersTableMap::SHIPPING_ID, $shippingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shippingId['max'])) {
                $this->addUsingAlias(OrdersTableMap::SHIPPING_ID, $shippingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::SHIPPING_ID, $shippingId, $comparison);
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
     * @see       filterByBilling()
     *
     * @param     mixed $billingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByBillingId($billingId = null, $comparison = null)
    {
        if (is_array($billingId)) {
            $useMinMax = false;
            if (isset($billingId['min'])) {
                $this->addUsingAlias(OrdersTableMap::BILLING_ID, $billingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($billingId['max'])) {
                $this->addUsingAlias(OrdersTableMap::BILLING_ID, $billingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrdersTableMap::BILLING_ID, $billingId, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(OrdersTableMap::USER_ID, $user->getUserId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrdersTableMap::USER_ID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
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
     * @return ChildOrdersQuery The current query, for fluid interface
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
     * Filter the query by a related \Billing object
     *
     * @param \Billing|ObjectCollection $billing The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByBilling($billing, $comparison = null)
    {
        if ($billing instanceof \Billing) {
            return $this
                ->addUsingAlias(OrdersTableMap::BILLING_ID, $billing->getBillingId(), $comparison);
        } elseif ($billing instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrdersTableMap::BILLING_ID, $billing->toKeyValue('PrimaryKey', 'BillingId'), $comparison);
        } else {
            throw new PropelException('filterByBilling() only accepts arguments of type \Billing or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Billing relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function joinBilling($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Billing');

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
            $this->addJoinObject($join, 'Billing');
        }

        return $this;
    }

    /**
     * Use the Billing relation Billing object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \BillingQuery A secondary query class using the current class as primary query
     */
    public function useBillingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBilling($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Billing', '\BillingQuery');
    }

    /**
     * Filter the query by a related \ShippingAddress object
     *
     * @param \ShippingAddress|ObjectCollection $shippingAddress The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByShippingAddress($shippingAddress, $comparison = null)
    {
        if ($shippingAddress instanceof \ShippingAddress) {
            return $this
                ->addUsingAlias(OrdersTableMap::SHIPPING_ID, $shippingAddress->getShippingId(), $comparison);
        } elseif ($shippingAddress instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrdersTableMap::SHIPPING_ID, $shippingAddress->toKeyValue('PrimaryKey', 'ShippingId'), $comparison);
        } else {
            throw new PropelException('filterByShippingAddress() only accepts arguments of type \ShippingAddress or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ShippingAddress relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function joinShippingAddress($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ShippingAddress');

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
            $this->addJoinObject($join, 'ShippingAddress');
        }

        return $this;
    }

    /**
     * Use the ShippingAddress relation ShippingAddress object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ShippingAddressQuery A secondary query class using the current class as primary query
     */
    public function useShippingAddressQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinShippingAddress($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ShippingAddress', '\ShippingAddressQuery');
    }

    /**
     * Filter the query by a related \OrderItems object
     *
     * @param \OrderItems|ObjectCollection $orderItems  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByOrderItems($orderItems, $comparison = null)
    {
        if ($orderItems instanceof \OrderItems) {
            return $this
                ->addUsingAlias(OrdersTableMap::ORDER_ID, $orderItems->getOrderId(), $comparison);
        } elseif ($orderItems instanceof ObjectCollection) {
            return $this
                ->useOrderItemsQuery()
                ->filterByPrimaryKeys($orderItems->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrderItems() only accepts arguments of type \OrderItems or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderItems relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function joinOrderItems($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderItems');

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
            $this->addJoinObject($join, 'OrderItems');
        }

        return $this;
    }

    /**
     * Use the OrderItems relation OrderItems object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \OrderItemsQuery A secondary query class using the current class as primary query
     */
    public function useOrderItemsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderItems($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderItems', '\OrderItemsQuery');
    }

    /**
     * Filter the query by a related \CustomItem object
     *
     * @param \CustomItem|ObjectCollection $customItem  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function filterByCustomItem($customItem, $comparison = null)
    {
        if ($customItem instanceof \CustomItem) {
            return $this
                ->addUsingAlias(OrdersTableMap::ORDER_ID, $customItem->getOrderId(), $comparison);
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
     * @return ChildOrdersQuery The current query, for fluid interface
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
     * @param   ChildOrders $orders Object to remove from the list of results
     *
     * @return ChildOrdersQuery The current query, for fluid interface
     */
    public function prune($orders = null)
    {
        if ($orders) {
            $this->addUsingAlias(OrdersTableMap::ORDER_ID, $orders->getOrderId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the orders table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrdersTableMap::DATABASE_NAME);
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
            OrdersTableMap::clearInstancePool();
            OrdersTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOrders or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOrders object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(OrdersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrdersTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        OrdersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrdersTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // OrdersQuery
