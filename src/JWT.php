<?php

namespace iMemento\JWT;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

/**
 * Class JWT
 */
class JWT
{
    public static function setLeeway(int $leeway)
    {
        FirebaseJWT::$leeway = $leeway;
    }

    /**
     * @return mixed
     *
     * @throws InvalidTokenException
     */
    public static function getPayload(string $jwt)
    {
        if (empty($jwt)) {
            throw new InvalidTokenException('The token is missing or empty.');
        }

        // get the issuer from payload without verifying the signature and the timestamps
        $tks = explode('.', $jwt);

        if (count($tks) !== 3) {
            throw new InvalidTokenException('Wrong number of segments.');
        }

        $bodyb64 = $tks[1];

        if (null === $payload = FirebaseJWT::jsonDecode(FirebaseJWT::urlsafeB64Decode($bodyb64))) {
            throw new InvalidTokenException('Invalid claims encoding.');
        }

        return $payload;
    }

    /**
     * @return mixed
     */
    public static function decode(string $jwt, $publicKey)
    {
        return FirebaseJWT::decode($jwt, new Key($publicKey, 'RS256'));
    }

    /**
     * @return mixed
     */
    public static function encode(array $payload, $privateKey)
    {
        return FirebaseJWT::encode($payload, $privateKey, 'RS256');
    }

    /**
     * @return resource
     */
    public static function getPublicKey($path)
    {
        return openssl_get_publickey(file_get_contents($path));
    }

    /**
     * @return bool|resource
     */
    public static function getPrivateKey($path)
    {
        return openssl_get_privatekey(file_get_contents($path));
    }
}
