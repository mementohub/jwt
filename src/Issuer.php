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
     * @var string
     */
    public $name;
    /**
     * @var
     */
    public $private_key;
    /**
     * @var string
     */
    public $session_id;
    /**
     * @var
     */
    public $token_store;

    /**
     * Issuer constructor.
     *
     * @param string            $name
     * @param                   $private_key
     * @param string|null       $session_id
     * @param TokenStore|null   $token_store
     */
    public function __construct(string $name, $private_key, string $session_id = null, TokenStore $token_store = null)
    {
        $this->name = $name;
        $this->private_key = $private_key;
        $this->session_id = $session_id;
        $this->token_store = $token_store;
    }
}