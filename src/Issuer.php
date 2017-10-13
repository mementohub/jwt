<?php

namespace iMemento\JWT;

/**
 * Class Issuer
 *
 * @package iMemento\JWT
 */
class Issuer
{
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $private_key;
    /**
     * @var
     */
    public $token_store;
    /**
     * @var string
     */
    public $session_id;

    /**
     * Issuer constructor.
     *
     * @param string            $name
     * @param                   $private_key
     * @param TokenStore|null   $token_store
     */
    public function __construct(string $name, $private_key, TokenStore $token_store = null)
    {
        $this->name = $name;
        $this->private_key = $private_key;
        $this->token_store = $token_store;
    }

    /**
     * @param $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }
}