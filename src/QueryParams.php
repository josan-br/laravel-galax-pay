<?php

namespace JosanBr\GalaxPay;

/**
 * Galax Pay URL Query Params
 * 
 * @property int limit
 * @property int startAt
 * @property string myIds
 * @property string createdAtFrom Y-m-d
 * @property string createdAtTo Y-m-d
 * @property string createdOrUpdatedAtFrom Y-m-d
 * @property string createdOrUpdatedAtTo Y-m-d
 * @property string order
 * - createdAt.asc | createdAt.desc | updatedAt.asc | updatedAt.desc
 */
class QueryParams
{
    public const ORDER_CREATE_AT_ASC = 'createdAt.asc';

    public const ORDER_CREATE_AT_DESC = 'createdAt.desc';

    public const ORDER_UPDATE_AT_ASC = 'updatedAt.asc';

    public const ORDER_UPDATE_AT_DESC = 'updatedAt.desc';

    /**
     * Default Query Params
     * 
     * @var array
     */
    private static $queryParams = [
        /**
         * Maximum number of records to bring.
         */
        'limit' => 100,
        /**
         * Initial pointer to bring up the records.
         */
        'startAt' => 0,
        /**
         * Billing ids on your system. Separate each id with a comma.
         */
        'myIds' => null,
        /**
         * Result ordering. String that should be assembled as follows: EntityField.OrderType
         */
        'order' => null,
        /**
         * Initial creation date.
         */
        'createdAtTo' => null,
        /**
         * Initial creation date.
         */
        'createdAtFrom' => null,
        /**
         * Initial creation / update date.
         */
        'createdOrUpdatedAtTo' => null,
        /**
         * Final creation / update date.
         */
        'createdOrUpdatedAtFrom' => null,
    ];

    /**
     * Initialize Query Params
     * 
     * @param array $queryParams
     * @return void
     */
    public function __construct(array $queryParams = [])
    {
        foreach ($queryParams as $property => $value)
            self::$queryParams[$property] = $value;
    }

    /**
     * Get query param
     * 
     * @param string $property
     * @return mixed|null
     */
    public function __get($property)
    {
        if (array_key_exists($property, self::$queryParams))
            return self::$queryParams[$property];
        return null;
    }

    /**
     * Set query param
     * 
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function __set($property, $value)
    {
        self::$queryParams[$property] = $value;
    }

    /**
     * Get all url query params
     * 
     * @return array
     */
    public function all(): array
    {
        return self::$queryParams;
    }

    /**
     * Build URL Query Params
     * 
     * @param array $mergeParmas Add more params before building
     * @return string
     */
    public static function build(array $mergeParmas = []): string
    {
        $params = array_merge(self::$queryParams, $mergeParmas);

        foreach ($params as $key => $value)
            if (is_null($value)) unset($params[$key]);

        return '?' . http_build_query($params);
    }

    /**
     * Extract parameters from URL
     * 
     * @param string $url
     * @return \JosanBr\GalaxPay\QueryParams
     */
    public static function extract(string $url): QueryParams
    {
        parse_str(explode('?', $url)[1], $queryParams);
        return new QueryParams($queryParams);
    }
}
