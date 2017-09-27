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
     * Issuer constructor.
     *
     * @param string      $name
     * @param             $private_key
     * @param string|null $session_id
     */
    public function __construct(string $name, $private_key, string $session_id = null)
    {
        $this->name = $name;
        $this->private_key = $private_key;
        $this->session_id = $session_id;
    }
}