<?php

namespace iMemento\JWT\Tests;

use iMemento\JWT\JWT;
use PHPUnit\Framework\TestCase;

class JWTTest extends TestCase
{
    public function test_encoding()
    {
        $private_key = JWT::getPrivateKey(__DIR__.'/private_key');

        $payload = [
            'iss' => 'test',
            'test' => 'true',
        ];

        $result = JWT::encode($payload, $private_key);

        $this->assertStringMatchesFormat('%s.%s.%s', $result);
    }

    public function test_decoding()
    {
        $public_key = JWT::getPublicKey(__DIR__.'/public_key');

        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJ0ZXN0IiwidGVzdCI6InRydWUifQ.gualydTBOme5_IvtI94jHlDjKJu3yMLKdDjLgiGUK9Ha4WrSUANJQnCumppsAfK7ALP2ogmFRhNn62_NaIm0_PPgFAQni-rRUfJdubr19ewU7MfZ5v_8tBFkljr6dmq442iQ3Wji0-hZY65WGzvI_kBM7xN9UbFPRexfod7CKL4';

        $result = JWT::decode($jwt, $public_key);

        $this->assertObjectHasProperty('iss', $result);
    }

    public function test_returns_correct_payload()
    {
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJ0ZXN0IiwidGVzdCI6InRydWUifQ.gualydTBOme5_IvtI94jHlDjKJu3yMLKdDjLgiGUK9Ha4WrSUANJQnCumppsAfK7ALP2ogmFRhNn62_NaIm0_PPgFAQni-rRUfJdubr19ewU7MfZ5v_8tBFkljr6dmq442iQ3Wji0-hZY65WGzvI_kBM7xN9UbFPRexfod7CKL4';

        $payload = JWT::getPayload($jwt);

        $this->assertObjectHasProperty('iss', $payload);
    }
}
