<?php

namespace iMemento\JWT;

interface TokenStore
{

    public function get($key);

    public function put($key, $token, $minutes);

    public function forget($key);

}