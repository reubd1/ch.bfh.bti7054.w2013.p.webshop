<?php

namespace Base;

use \ShippingAddress as ChildShippingAddress;
use \ShippingAddressQuery as ChildShippingAddressQuery;
use \Exception;
use \PDO;
use Map\ShippingAddressTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'shipping_address' table.
 *
 *
 *
 * @method     ChildShippingAddressQuery orderByShippingId($order = Criteria::ASC) Order by the shipping_id column
 * @method     ChildShippingAddressQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildShippingAddressQuery orderByStreet($order = Criteria::ASC) Order by the street column
 * @method     ChildShippingAddressQuery orderByZip($order = Criteria::ASC) Order by the zip column
 * @method     ChildShippingAddressQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildShippingAddressQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     ChildShippingAddressQuery orderByAvailable($order = Criteria::ASC) Order by the available column
 * @method     ChildShippingAddressQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 *
 * @method     ChildShippingAddressQuery groupByShippingId() Group by the shipping_id column
 * @method     ChildShippingAddressQuery groupByName() Group by the name column
 * @method     ChildShippingAddressQuery groupByStreet() Group by the street column
 * @method     ChildShippingAddressQuery groupByZip() Group by the zip column
 * @method     ChildShippingAddressQuery groupByCity() Group by the city column
 * @method     ChildShippingAddressQuery groupByCountry() Group by the country column
 * @method     ChildShippingAddressQuery groupByAvailable() Group by the available column
 * @method     ChildShippingAddressQuery groupByUserId() Group by the user_id column
 *
 * @method     ChildShippingAddressQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildShippingAddressQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildShippingAddressQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildShippingAddressQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildShippingAddressQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildShippingAddressQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildShippingAddressQuery leftJoinOrders($relationAlias = null) Adds a LEFT JOIN clause to the query using the Orders relation
 * @method     ChildShippingAddressQuery rightJoinOrders($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Orders relation
 * @method     ChildShippingAddressQuery innerJoinOrders($relationAlias = null) Adds a INNER JOIN clause to the query using the Orders relation
 *
 * @method     ChildShippingAddress findOne(ConnectionInterface $con = null) Return the first ChildShippingAddress matching the query
 * @method     ChildShippingAddress findOneOrCreate(ConnectionInterface $con = null) Return the first ChildShippingAddress matching the query, or a new ChildShippingAddress object populated from the query conditions when no match is found
 *
 * @method     ChildShippingAddress findOneByShippingId(int $shipping_id) Return the first ChildShippingAddress filtered by the shipping_id column
 * @method     ChildShippingAddress findOneByName(string $name) Return the first ChildShippingAddress filtered by the name column
 * @method     ChildShippingAddress findOneByStreet(string $street) Return the first ChildShippingAddress filtered by the street column
 * @method     ChildShippingAddress findOneByZip(int $zip) Return the first ChildShippingAddress filtered by the zip column
 * @method     ChildShippingAddress findOneByCity(string $city) Return the first ChildShippingAddress filtered by the city column
 * @method     ChildShippingAddress findOneByCountry(string $country) Return the first ChildShippingAddress filtered by the country column
 * @method     ChildShippingAddress findOneByAvailable(boolean $available) Return the first ChildShippingAddress filtered by the available column
 * @method     ChildShippingAddress findOneByUserId(int $user_id) Return the first ChildShippingAddress filtered by the user_id column
 *
 * @method     array findByShippingId(int $shipping_id) Return ChildShippingAddress objects filtered by the shipping_id column
 * @method     array findByName(string $name) Return ChildShippingAddress objects filtered by the name column
 * @method     array findByStreet(string $street) Return ChildShippingAddress objects filtered by the street column
 * @method     array findByZip(int $zip) Return ChildShippingAddress objects filtered by the zip column
 * @method     array findByCity(string $city) Return ChildShippingAddress objects filtered by the city column
 * @method     array findByCountry(string $country) Return ChildShippingAddress objects filtered by the country column
 * @method     array findByAvailable(boolean $available) Return ChildShippingAddress objects filtered by the available column
 * @method     array findByUserId(int $user_id) Return ChildShippingAddress objects filtered by the user_id column
 *
 */
abstract class ShippingAddressQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ShippingAddressQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'bti7054', $modelName = '\\ShippingAddress', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildShippingAddressQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildShippingAddressQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \ShippingAddressQuery) {
            return $criteria;
        }
        $query = new \ShippingAddressQuery();
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
     * @return ChildShippingAddress|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ShippingAddressTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ShippingAddressTableMap::DATABASE_NAME);
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
     * @return   ChildShippingAddress A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT SHIPPING_ID, NAME, STREET, ZIP, CITY, COUNTRY, AVAILABLE, USER_ID FROM shipping_address WHERE SHIPPING_ID = :p0';
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
            $obj = new ChildShippingAddress();
            $obj->hydrate($row);
            ShippingAddressTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildShippingAddress|array|mixed the result, formatted by the current formatter
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
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ShippingAddressTableMap::SHIPPING_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ShippingAddressTableMap::SHIPPING_ID, $keys, Criteria::IN);
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
     * @param     mixed $shippingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByShippingId($shippingId = null, $comparison = null)
    {
        if (is_array($shippingId)) {
            $useMinMax = false;
            if (isset($shippingId['min'])) {
                $this->addUsingAlias(ShippingAddressTableMap::SHIPPING_ID, $shippingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shippingId['max'])) {
                $this->addUsingAlias(ShippingAddressTableMap::SHIPPING_ID, $shippingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShippingAddressTableMap::SHIPPING_ID, $shippingId, $comparison);
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
     * @return ChildShippingAddressQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ShippingAddressTableMap::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the street column
     *
     * Example usage:
     * <code>
     * $query->filterByStreet('fooValue');   // WHERE street = 'fooValue'
     * $query->filterByStreet('%fooValue%'); // WHERE street LIKE '%fooValue%'
     * </code>
     *
     * @param     string $street The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByStreet($street = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($street)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $street)) {
                $street = str_replace('*', '%', $street);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShippingAddressTableMap::STREET, $street, $comparison);
    }

    /**
     * Filter the query on the zip column
     *
     * Example usage:
     * <code>
     * $query->filterByZip(1234); // WHERE zip = 1234
     * $query->filterByZip(array(12, 34)); // WHERE zip IN (12, 34)
     * $query->filterByZip(array('min' => 12)); // WHERE zip > 12
     * </code>
     *
     * @param     mixed $zip The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByZip($zip = null, $comparison = null)
    {
        if (is_array($zip)) {
            $useMinMax = false;
            if (isset($zip['min'])) {
                $this->addUsingAlias(ShippingAddressTableMap::ZIP, $zip['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($zip['max'])) {
                $this->addUsingAlias(ShippingAddressTableMap::ZIP, $zip['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShippingAddressTableMap::ZIP, $zip, $comparison);
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%'); // WHERE city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $city The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByCity($city = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $city)) {
                $city = str_replace('*', '%', $city);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShippingAddressTableMap::CITY, $city, $comparison);
    }

    /**
     * Filter the query on the country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue');   // WHERE country = 'fooValue'
     * $query->filterByCountry('%fooValue%'); // WHERE country LIKE '%fooValue%'
     * </code>
     *
     * @param     string $country The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByCountry($country = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($country)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $country)) {
                $country = str_replace('*', '%', $country);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ShippingAddressTableMap::COUNTRY, $country, $comparison);
    }

    /**
     * Filter the query on the available column
     *
     * Example usage:
     * <code>
     * $query->filterByAvailable(true); // WHERE available = true
     * $query->filterByAvailable('yes'); // WHERE available = true
     * </code>
     *
     * @param     boolean|string $available The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByAvailable($available = null, $comparison = null)
    {
        if (is_string($available)) {
            $available = in_array(strtolower($available), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ShippingAddressTableMap::AVAILABLE, $available, $comparison);
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
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(ShippingAddressTableMap::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(ShippingAddressTableMap::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ShippingAddressTableMap::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(ShippingAddressTableMap::USER_ID, $user->getUserId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ShippingAddressTableMap::USER_ID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
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
     * @return ChildShippingAddressQuery The current query, for fluid interface
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
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function filterByOrders($orders, $comparison = null)
    {
        if ($orders instanceof \Orders) {
            return $this
                ->addUsingAlias(ShippingAddressTableMap::SHIPPING_ID, $orders->getShippingId(), $comparison);
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
     * @return ChildShippingAddressQuery The current query, for fluid interface
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
     * @param   ChildShippingAddress $shippingAddress Object to remove from the list of results
     *
     * @return ChildShippingAddressQuery The current query, for fluid interface
     */
    public function prune($shippingAddress = null)
    {
        if ($shippingAddress) {
            $this->addUsingAlias(ShippingAddressTableMap::SHIPPING_ID, $shippingAddress->getShippingId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the shipping_address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ShippingAddressTableMap::DATABASE_NAME);
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
            ShippingAddressTableMap::clearInstancePool();
            ShippingAddressTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildShippingAddress or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildShippingAddress object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ShippingAddressTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ShippingAddressTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ShippingAddressTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ShippingAddressTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ShippingAddressQuery
