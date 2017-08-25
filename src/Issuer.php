<?php

namespace iMemento\JWT;

class Issuer
{
    public $name;
    public $private_key;

    public function __construct(string $name, $private_key)
    {
        $this->name = $name;
        $this->private_key = $private_key;
    }
}