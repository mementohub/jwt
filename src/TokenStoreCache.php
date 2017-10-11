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
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->store = $cache;
    }

    /**
     * @param $key
     */
    public function get($key)
    {
        $this->store->get($key);
    }

    /**
     * @param $key
     * @param $token
     * @param $minutes
     */
    public function put($key, $token, $minutes = 48 * 60 * 60)
    {
        $this->store->put($key, $token, $minutes);
    }

    /**
     * @param $key
     */
    public function forget($key)
    {
        $this->store->get($key);
    }

}