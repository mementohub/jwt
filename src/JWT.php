<?php

namespace Imemento\JWT;

use Firebase\JWT\JWT as FirebaseJWT;

/**
 * Class JWT
 *
 * @package Imemento\JWT
 */
class JWT
{

    /**
     * @var int
     */
    protected $leeway = 3;

    /**
     * @var string
     */
    protected $alg = 'RS256';

    /**
     * @var
     */
    protected $token;

    /**
     * @var
     */
    protected $issuer;

    /**
     * @var
     */
    protected $payload;


    /**
     * JWT constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        FirebaseJWT::$leeway = $this->leeway;

        $this->token = $token;

        $this->setPayload();
    }

    /**
     * @param $leeway
     * @return $this
     */
    public function setLeeway($leeway)
    {
        $this->leeway = $leeway;

        return $this;
    }

    public function getLeeway()
    {
        return $this->leeway;
    }

    /**
     *
     */
    public function validate()
    {

    }

    /**
     * @return mixed
     */
    public function getIssuer()
    {
        return $this->get('iss');
    }

    /**
     * @throws \Exception
     */
    public function setPayload()
    {
        $elements = explode('.', $this->token);

        if(!isset($elements[1]))
            throw new \Exception('Payload missing.');

        $this->payload = FirebaseJWT::jsonDecode(
            FirebaseJWT::urlsafeB64Decode($elements[1])
        );
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

        throw new \Exception('Key not in payload.');
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param $jwt
     * @param $publicKey
     * @return mixed
     */
    public function decode($jwt, $publicKey)
    {
        return FirebaseJWT::decode($jwt, $publicKey, [self::ALG]);
    }

    /**
     * @param $token
     * @param $privateKey
     * @return mixed
     */
    public static function encode($token, $privateKey)
    {
        return FirebaseJWT::encode($token, $privateKey, self::ALG);
    }

}