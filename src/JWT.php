<?php

namespace Imemento\JWT;

use Firebase\JWT\JWT as FirebaseJWT;
use iMemento\JWT\Exceptions\InvalidTokenException;
use iMemento\JWT\Exceptions\TokenNotDecodedException;

/**
 * Class JWT
 *
 * @package Imemento\JWT
 */
class JWT
{

    /**
     * @var
     */
    protected $jwt;

    /**
     * @var
     */
    protected $issuer;

    /**
     * @var
     */
    protected $payload;

    /**
     * @var
     */
    protected $publicKey;


    /**
     * JWT constructor.
     *
     * @param $jwt
     */
    public function __construct($jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @param $leeway
     * @return $this
     */
    public function setLeeway($leeway)
    {
        FirebaseJWT::$leeway = $leeway;

        return $this;
    }

    /**
     * @return mixed
     * @throws InvalidTokenException
     */
    public function getIssuer()
    {
        //if already decoded, just return it
        if(!is_null($this->issuer))
            return $this->issuer;

        //get the issuer from payload without verifying the signature and the timestamps
        $tks = explode('.', $this->jwt);

        if(count($tks) !== 3) {
            throw new InvalidTokenException('Wrong number of segments.');
        }

        $bodyb64 = $tks[1];

        if(null === $payload = FirebaseJWT::jsonDecode(FirebaseJWT::urlsafeB64Decode($bodyb64))) {
            throw new InvalidTokenException('Invalid claims encoding.');
        }

        if(empty($payload->iss)) {
            throw new InvalidTokenException('Issuer not set.');
        }

        $this->issuer = $payload->iss;

        return $this->issuer;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function get(string $key)
    {
        if(isset($this->payload[$key])) {
            return $this->payload[$key];
        }

        if(empty($this->payload)) {
            throw new TokenNotDecodedException('Token is not decoded yet.');
        }

        throw new \UnexpectedValueException('Key not in payload.');
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param        $publicKey
     * @param string $alg
     * @return mixed
     */
    public function decode($publicKey, $alg = 'RS256')
    {
        $key = openssl_get_publickey(file_get_contents($publicKey));

        $this->payload = FirebaseJWT::decode($this->jwt, $key, [$alg]);

        return $this->payload;
    }

    /**
     * @param        $payload
     * @param        $privateKey
     * @param string $alg
     * @return mixed
     */
    public static function encode($payload, $privateKey, $alg = 'RS256')
    {
        $key = openssl_get_privatekey(file_get_contents($privateKey));

        return FirebaseJWT::encode($payload, $key, $alg);
    }

}