<?php

namespace Base;

use \CustomItem as ChildCustomItem;
use \CustomItemQuery as ChildCustomItemQuery;
use \Exception;
use \PDO;
use Map\CustomItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'custom_item' table.
 *
 *
 *
 * @method     ChildCustomItemQuery orderByCustomItemId($order = Criteria::ASC) Order by the custom_item_id column
 * @method     ChildCustomItemQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildCustomItemQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildCustomItemQuery orderByCakeId($order = Criteria::ASC) Order by the cake_id column
 * @method     ChildCustomItemQuery orderByToppingId($order = Criteria::ASC) Order by the topping_id column
 * @method     ChildCustomItemQuery orderByDecoId($order = Criteria::ASC) Order by the deco_id column
 *
 * @method     ChildCustomItemQuery groupByCustomItemId() Group by the custom_item_id column
 * @method     ChildCustomItemQuery groupByName() Group by the name column
 * @method     ChildCustomItemQuery groupByOrderId() Group by the order_id column
 * @method     ChildCustomItemQuery groupByCakeId() Group by the cake_id column
 * @method     ChildCustomItemQuery groupByToppingId() Group by the topping_id column
 * @method     ChildCustomItemQuery groupByDecoId() Group by the deco_id column
 *
 * @method     ChildCustomItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomItemQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildCustomItemQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildCustomItemQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildCustomItemQuery leftJoinCake($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cake relation
 * @method     ChildCustomItemQuery rightJoinCake($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cake relation
 * @method     ChildCustomItemQuery innerJoinCake($relationAlias = null) Adds a INNER JOIN clause to the query using the Cake relation
 *
 * @method     ChildCustomItemQuery leftJoinTopping($relationAlias = null) Adds a LEFT JOIN clause to the query using the Topping relation
 * @method     ChildCustomItemQuery rightJoinTopping($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Topping relation
 * @method     ChildCustomItemQuery innerJoinTopping($relationAlias = null) Adds a INNER JOIN clause to the query using the Topping relation
 *
 * @method     ChildCustomItemQuery leftJoinDecoration($relationAlias = null) Adds a LEFT JOIN clause to the query using the Decoration relation
 * @method     ChildCustomItemQuery rightJoinDecoration($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Decoration relation
 * @method     ChildCustomItemQuery innerJoinDecoration($relationAlias = null) Adds a INNER JOIN clause to the query using the Decoration relation
 *
 * @method     ChildCustomItem findOne(ConnectionInterface $con = null) Return the first ChildCustomItem matching the query
 * @method     ChildCustomItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCustomItem matching the query, or a new ChildCustomItem object populated from the query conditions when no match is found
 *
 * @method     ChildCustomItem findOneByCustomItemId(int $custom_item_id) Return the first ChildCustomItem filtered by the custom_item_id column
 * @method     ChildCustomItem findOneByName(string $name) Return the first ChildCustomItem filtered by the name column
 * @method     ChildCustomItem findOneByOrderId(int $order_id) Return the first ChildCustomItem filtered by the order_id column
 * @method     ChildCustomItem findOneByCakeId(int $cake_id) Return the first ChildCustomItem filtered by the cake_id column
 * @method     ChildCustomItem findOneByToppingId(int $topping_id) Return the first ChildCustomItem filtered by the topping_id column
 * @method     ChildCustomItem findOneByDecoId(int $deco_id) Return the first ChildCustomItem filtered by the deco_id column
 *
 * @method     array findByCustomItemId(int $custom_item_id) Return ChildCustomItem objects filtered by the custom_item_id column
 * @method     array findByName(string $name) Return ChildCustomItem objects filtered by the name column
 * @method     array findByOrderId(int $order_id) Return ChildCustomItem objects filtered by the order_id column
 * @method     array findByCakeId(int $cake_id) Return ChildCustomItem objects filtered by the cake_id column
 * @method     array findByToppingId(int $topping_id) Return ChildCustomItem objects filtered by the topping_id column
 * @method     array findByDecoId(int $deco_id) Return ChildCustomItem objects filtered by the deco_id column
 *
 */
abstract class CustomItemQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\CustomItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'bti7054', $modelName = '\\CustomItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomItemQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CustomItemQuery) {
            return $criteria;
        }
        $query = new \CustomItemQuery();
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
     * @return ChildCustomItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CustomItemTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomItemTableMap::DATABASE_NAME);
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
     * @return   ChildCustomItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT CUSTOM_ITEM_ID, NAME, ORDER_ID, CAKE_ID, TOPPING_ID, DECO_ID FROM custom_item WHERE CUSTOM_ITEM_ID = :p0';
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
            $obj = new ChildCustomItem();
            $obj->hydrate($row);
            CustomItemTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCustomItem|array|mixed the result, formatted by the current formatter
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
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CustomItemTableMap::CUSTOM_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CustomItemTableMap::CUSTOM_ITEM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the custom_item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomItemId(1234); // WHERE custom_item_id = 1234
     * $query->filterByCustomItemId(array(12, 34)); // WHERE custom_item_id IN (12, 34)
     * $query->filterByCustomItemId(array('min' => 12)); // WHERE custom_item_id > 12
     * </code>
     *
     * @param     mixed $customItemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByCustomItemId($customItemId = null, $comparison = null)
    {
        if (is_array($customItemId)) {
            $useMinMax = false;
            if (isset($customItemId['min'])) {
                $this->addUsingAlias(CustomItemTableMap::CUSTOM_ITEM_ID, $customItemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customItemId['max'])) {
                $this->addUsingAlias(CustomItemTableMap::CUSTOM_ITEM_ID, $customItemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomItemTableMap::CUSTOM_ITEM_ID, $customItemId, $comparison);
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
     * @return ChildCustomItemQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CustomItemTableMap::NAME, $name, $comparison);
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
     * @see       filterByOrder()
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(CustomItemTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(CustomItemTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomItemTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the cake_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCakeId(1234); // WHERE cake_id = 1234
     * $query->filterByCakeId(array(12, 34)); // WHERE cake_id IN (12, 34)
     * $query->filterByCakeId(array('min' => 12)); // WHERE cake_id > 12
     * </code>
     *
     * @see       filterByCake()
     *
     * @param     mixed $cakeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByCakeId($cakeId = null, $comparison = null)
    {
        if (is_array($cakeId)) {
            $useMinMax = false;
            if (isset($cakeId['min'])) {
                $this->addUsingAlias(CustomItemTableMap::CAKE_ID, $cakeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cakeId['max'])) {
                $this->addUsingAlias(CustomItemTableMap::CAKE_ID, $cakeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomItemTableMap::CAKE_ID, $cakeId, $comparison);
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
     * @see       filterByTopping()
     *
     * @param     mixed $toppingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByToppingId($toppingId = null, $comparison = null)
    {
        if (is_array($toppingId)) {
            $useMinMax = false;
            if (isset($toppingId['min'])) {
                $this->addUsingAlias(CustomItemTableMap::TOPPING_ID, $toppingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($toppingId['max'])) {
                $this->addUsingAlias(CustomItemTableMap::TOPPING_ID, $toppingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomItemTableMap::TOPPING_ID, $toppingId, $comparison);
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
     * @see       filterByDecoration()
     *
     * @param     mixed $decoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByDecoId($decoId = null, $comparison = null)
    {
        if (is_array($decoId)) {
            $useMinMax = false;
            if (isset($decoId['min'])) {
                $this->addUsingAlias(CustomItemTableMap::DECO_ID, $decoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($decoId['max'])) {
                $this->addUsingAlias(CustomItemTableMap::DECO_ID, $decoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomItemTableMap::DECO_ID, $decoId, $comparison);
    }

    /**
     * Filter the query by a related \Order object
     *
     * @param \Order|ObjectCollection $order The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByOrder($order, $comparison = null)
    {
        if ($order instanceof \Order) {
            return $this
                ->addUsingAlias(CustomItemTableMap::ORDER_ID, $order->getOrderId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomItemTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'OrderId'), $comparison);
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function joinOrder($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Order');

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
            $this->addJoinObject($join, 'Order');
        }

        return $this;
    }

    /**
     * Use the Order relation Order object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\OrderQuery');
    }

    /**
     * Filter the query by a related \Cake object
     *
     * @param \Cake|ObjectCollection $cake The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByCake($cake, $comparison = null)
    {
        if ($cake instanceof \Cake) {
            return $this
                ->addUsingAlias(CustomItemTableMap::CAKE_ID, $cake->getCakeId(), $comparison);
        } elseif ($cake instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomItemTableMap::CAKE_ID, $cake->toKeyValue('PrimaryKey', 'CakeId'), $comparison);
        } else {
            throw new PropelException('filterByCake() only accepts arguments of type \Cake or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cake relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function joinCake($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cake');

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
            $this->addJoinObject($join, 'Cake');
        }

        return $this;
    }

    /**
     * Use the Cake relation Cake object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CakeQuery A secondary query class using the current class as primary query
     */
    public function useCakeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCake($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cake', '\CakeQuery');
    }

    /**
     * Filter the query by a related \Topping object
     *
     * @param \Topping|ObjectCollection $topping The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByTopping($topping, $comparison = null)
    {
        if ($topping instanceof \Topping) {
            return $this
                ->addUsingAlias(CustomItemTableMap::TOPPING_ID, $topping->getToppingId(), $comparison);
        } elseif ($topping instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomItemTableMap::TOPPING_ID, $topping->toKeyValue('PrimaryKey', 'ToppingId'), $comparison);
        } else {
            throw new PropelException('filterByTopping() only accepts arguments of type \Topping or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Topping relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function joinTopping($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Topping');

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
            $this->addJoinObject($join, 'Topping');
        }

        return $this;
    }

    /**
     * Use the Topping relation Topping object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ToppingQuery A secondary query class using the current class as primary query
     */
    public function useToppingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTopping($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Topping', '\ToppingQuery');
    }

    /**
     * Filter the query by a related \Decoration object
     *
     * @param \Decoration|ObjectCollection $decoration The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function filterByDecoration($decoration, $comparison = null)
    {
        if ($decoration instanceof \Decoration) {
            return $this
                ->addUsingAlias(CustomItemTableMap::DECO_ID, $decoration->getDecoId(), $comparison);
        } elseif ($decoration instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomItemTableMap::DECO_ID, $decoration->toKeyValue('PrimaryKey', 'DecoId'), $comparison);
        } else {
            throw new PropelException('filterByDecoration() only accepts arguments of type \Decoration or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Decoration relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function joinDecoration($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Decoration');

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
            $this->addJoinObject($join, 'Decoration');
        }

        return $this;
    }

    /**
     * Use the Decoration relation Decoration object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \DecorationQuery A secondary query class using the current class as primary query
     */
    public function useDecorationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDecoration($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Decoration', '\DecorationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCustomItem $customItem Object to remove from the list of results
     *
     * @return ChildCustomItemQuery The current query, for fluid interface
     */
    public function prune($customItem = null)
    {
        if ($customItem) {
            $this->addUsingAlias(CustomItemTableMap::CUSTOM_ITEM_ID, $customItem->getCustomItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the custom_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomItemTableMap::DATABASE_NAME);
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
            CustomItemTableMap::clearInstancePool();
            CustomItemTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCustomItem or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCustomItem object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomItemTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        CustomItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomItemTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CustomItemQuery
