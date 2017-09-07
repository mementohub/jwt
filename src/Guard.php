<?php

namespace iMemento\JWT;

use iMemento\JWT\Exceptions\InvalidPermissionsException;

/**
 * Class Guard
 *
 * @package iMemento\JWT
 */
class Guard
{

    /**
     * @var
     */
    protected $consumer;

    /**
     * @var
     */
    protected $permissions;

    /**
     * @var
     */
    protected $user;

    /**
     * Guard constructor.
     *
     * @param null $jwt
     */
    public function __construct($jwt = null)
    {
        if($jwt) $this->unpack($jwt);
    }

    /**
     * @param $jwt
     * @throws InvalidPermissionsException
     */
    public function unpack($jwt)
    {
        $this->consumer = $this->decode($jwt);
        $this->permissions = $this->decode($this->consumer->perms);
        $this->user = $this->decode($this->permissions->user);

        //if all decoding went well, verify consumer is correct
        if($this->consumer->iss !== $this->permissions->cns) {
            throw new InvalidPermissionsException('The permissions are not issued for the current consumer!');
        }

    }

    /**
     * @param $jwt
     * @return mixed|null
     */
    protected function decode($jwt)
    {
        if(!empty($jwt)) {
            $jwt = new JWT($jwt);
            $issuer = $jwt->getIssuer();
            $public_key = openssl_get_publickey(file_get_contents(base_path('keys/'.$issuer)));
            return $jwt->decode($public_key);
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getConsumer()
    {
        return $this->consumer;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
    
}