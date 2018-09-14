<?php

namespace iMemento\JWT;

use Firebase\JWT\JWT as FirebaseJWT;

/**
 * Class JWT
 *
 * @package iMemento\JWT
 */
class JWT
{
    /**
     * @param $leeway
     */
    public static function setLeeway(int $leeway)
    {
        FirebaseJWT::$leeway = $leeway;
    }

    /**
     * @param string $jwt
     * @return mixed
     * @throws InvalidTokenException
     */
    public static function getPayload(string $jwt)
    {
        if(empty($jwt))
            throw new InvalidTokenException('The token is missing or empty.');

        //get the issuer from payload without verifying the signature and the timestamps
        $tks = explode('.', $jwt);

        if(count($tks) !== 3)
            throw new InvalidTokenException('Wrong number of segments.');

        $bodyb64 = $tks[1];

        if(null === $payload = FirebaseJWT::jsonDecode(FirebaseJWT::urlsafeB64Decode($bodyb64)))
            throw new InvalidTokenException('Invalid claims encoding.');

        return $payload;
    }

    /**
     * @param string $jwt
     * @param        $publicKey
     * @return mixed
     */
    public static function decode(string $jwt, $publicKey)
    {
        return FirebaseJWT::decode($jwt, $publicKey, ['RS256']);
    }

    /**
     * @param        $payload
     * @param        $privateKey
     * @return mixed
     */
    public static function encode(array $payload, $privateKey)
    {
        return FirebaseJWT::encode($payload, $privateKey, 'RS256');
    }

    /**
     * @param $path
     * @return resource
     */
    public static function getPublicKey($path)
    {
        return openssl_get_publickey(file_get_contents($path));
    }

    /**
     * @param $path
     * @return bool|resource
     */
    public static function getPrivateKey($path)
    {
        return openssl_get_privatekey(file_get_contents($path));
    }

}