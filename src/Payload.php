<?php

namespace iMemento\JWT;

/**
 * Class Payload
 *
 * @package iMemento\JWT
 */
class Payload
{

    /**
     * Returns a payload that can be used in a jwt
     *
     * @param array $data
     * @param array $options
     * @return array
     */
    public static function createPayload(array $data, array $options = [])
    {
        $payload = [
            'exp' => time() + 60 * 60,
            #'nbf' => time(),
            #'iat' => time(),
            #'jti' => uniqid(null, true),
        ];

        return array_merge($payload, $data);
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
            'id' => $payload->sub,
            'name' => $payload->name,
        ];
    }
    
}