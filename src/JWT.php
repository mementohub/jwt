<?php

namespace iMemento\JWT;

use Firebase\JWT\JWT as FirebaseJWT;
use iMemento\Exceptions\InvalidTokenException;
use iMemento\JWT\Exceptions\TokenNotDecodedException;

/**
 * Class JWT
 *
 * @package iMemento\JWT
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

        if(empty($this->jwt)) {
            throw new InvalidTokenException('The token is missing or empty.');
        }

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
     * @return mixed
     */
    public function decode($publicKey)
    {
        $this->payload = FirebaseJWT::decode($this->jwt, $publicKey, ['RS256']);

        return $this->payload;
    }

    /**
     * @param        $payload
     * @param        $privateKey
     * @return mixed
     */
    public static function encode($payload, $privateKey)
    {
        return FirebaseJWT::encode($payload, $privateKey, 'RS256');
    }

}