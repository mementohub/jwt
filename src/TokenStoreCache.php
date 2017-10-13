<?php

namespace iMemento\JWT;

use Illuminate\Support\Facades\Cache;

/**
 * Class TokenStoreCache
 *
 * @package iMemento\JWT
 */
class TokenStoreCache implements TokenStore
{

    /**
     * @var Cache
     */
    protected $store;

    /**
     * TokenStoreCache constructor.
     *
     */
    public function __construct()
    {
        $this->store = app('cache');
    }

    /**
     * @param $key
     * @return \Illuminate\Contracts\Cache\Repository|mixed
     */
    public function get($key)
    {
        return $this->store->get($key);
    }

    /**
     * @param $key
     * @param $token
     * @param $minutes
     */
    public function put($key, $token, $minutes)
    {
        return $this->store->put($key, $token, $minutes);
    }

    /**
     * @param $key
     * @return \Illuminate\Contracts\Cache\Repository|mixed
     */
    public function forget($key)
    {
        return $this->store->get($key);
    }

}