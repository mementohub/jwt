<?php

namespace iMemento\JWT;

/**
 * Class Payload
 *
 * @package iMemento\JWT
 */
use iMemento\Exceptions\InvalidTokenException;

/**
 * Class Payload
 *
 * @package iMemento\JWT
 */
class Payload
{

    /**
     * @var int
     */
    protected static $exp = 15 * 60;

    /**
     * Returns a payload that can be used in a jwt
     *
     * @param array $data
     * @return array
     */
    public static function create(array $data)
    {
        $payload = [
            'exp' => time() + self::$exp,
        ];

        return array_merge($payload, $data);
    }

    /**
     * Refreshes an expired jwt
     *
     * @param array $payload
     * @return array
     * @throws InvalidTokenException
     */
    public static function refresh(array $payload)
    {
        if(empty($payload['exp']))
            throw new InvalidTokenException('The exp field is missing from the token.');

        $payload['exp'] = time() + self::$exp;

        return $payload;
    }

    /**
     * Returns an user array from the payload
     *
     * @param object $payload
     * @return array
     */
    public static function getUser($payload)
    {
        return [
            'id' => $payload->uid,
            'agency_id' => $payload->aid,
        ];
    }
    
}