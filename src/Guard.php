<?php

namespace iMemento\JWT;

use Firebase\JWT\ExpiredException;
use iMemento\Exceptions\ExpiredAuthTokenException;
use iMemento\Exceptions\ExpiredConsumerTokenException;
use iMemento\Exceptions\ExpiredPermsTokenException;
use iMemento\JWT\Exceptions\InvalidPermissionsException;

/**
 * Class Guard
 *
 * @package iMemento\JWT
 */
class Guard
{

    /**
     * Roles array containing user-agency roles and consumer roles
     * @var
     */
    protected $roles;

    /**
     * Decoded Consumer JWT
     * @var
     */
    protected $consumer;

    /**
     * Decoded Perms JWT
     * @var
     */
    protected $permissions;

    /**
     * Decoded Auth JWT
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
     * @throws ExpiredAuthTokenException
     * @throws ExpiredConsumerTokenException
     * @throws ExpiredPermsTokenException
     * @throws InvalidPermissionsException
     */
    public function unpack($jwt)
    {
        try {
            $this->consumer = $this->decode($jwt);
        } catch (ExpiredException $e) {
            throw new ExpiredConsumerTokenException('The Consumer token has expired.');
        }

        try {
            $this->permissions = $this->decode($this->consumer->perms);
        } catch (ExpiredException $e) {
            throw new ExpiredPermsTokenException('The Permissions token has expired.');
        }

        try {
            $this->user = $this->decode($this->permissions->user);
        } catch (ExpiredException $e) {
            throw new ExpiredAuthTokenException('The Auth token has expired.');
        }

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
     * Adds info taken from the JWT to a User model
     *
     * @param $model
     * @param $user
     * @param $roles
     * @param $permissions
     * @return mixed
     */
    public static function createUserModel($model, $user, $roles, $permissions)
    {
        //build the User model
        $model->id = $user ? $user->uid : null;
        $model->agency_id = $user ? $user->aid : null;
        $model->roles = $roles->ua;
        $model->consumer_roles = $roles->cns;

        //TODO: handle the exception when a given role is not defined

        //create the permissions array
        $ua_permissions = [];
        if($user) {
            foreach($model->roles as $role) {
                $ua_permissions = array_merge($ua_permissions, $permissions[$role]);
            }
        }

        //create the consumer permissions array
        $consumer_permissions = [];
        if(!empty($model->consumer_roles)) {
            foreach ($model->consumer_roles as $role) {
                $consumer_permissions = array_merge($consumer_permissions, $permissions[$role]);
            }
        }

        //intersect the permissions arrays
        //if user has no role, just use the consumer permissions
        $model->permissions = $consumer_permissions;
        if(!empty($ua_permissions)) {
            $model->permissions = array_intersect($ua_permissions, $consumer_permissions);
        }

        //TODO: maybe intersect the roles too

        return $model;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->permissions->roles;
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