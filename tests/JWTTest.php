<?php

use PHPUnit\Framework\TestCase;
use Imemento\JWT\Exceptions\InvalidTokenException;
use Imemento\JWT\Exceptions\TokenNotDecodedException;
use Imemento\JWT\JWT;

/**
 * @covers JWT
 */
final class JWTTest extends TestCase
{

    public function testCanBeCreatedFromValidToken()
    {
        $this->assertInstanceOf(
            JWT::class,
            new JWT('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJhdXRoIiwibmFtZSI6Ikdlb3JnZSIsImF1ZCI6ImV4YW1wbGUuY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDB9.YuCVuC6JA4RPedAfH6bt3zTP0iB7hwMdDbgsWA9z8AM4HEcOpzE0OghcTlo6xuS4FcifI9fl_rfZQjCtDh7p2LUxn0vdKT0oFlecaDRxu8PEx9CV8zS6h7oYKE6p3gMx0MMIzNTWIY7jOKBLSQInygA3Jv_xXAH22zoUaif10Xg')
        );
    }

    public function testCannotBeCreatedFromInvalidToken()
    {
        $this->expectException(InvalidTokenException::class);

        $jwt = new JWT('asd.YuCVuC6JA4RPedAfH6bt3zTP0iB7hwMdDbgsWA9z8AM4HEcOpzE0OghcTlo6xuS4FcifI9fl_rfZQjCtDh7p2LUxn0vdKT0oFlecaDRxu8PEx9CV8zS6h7oYKE6p3gMx0MMIzNTWIY7jOKBLSQInygA3Jv_xXAH22zoUaif10Xg');
        $jwt->getIssuer();
    }

    public function testTokenNotDecodedException()
    {
        $this->expectException(TokenNotDecodedException::class);

        $jwt = new JWT('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJhdXRoIiwibmFtZSI6Ikdlb3JnZSIsImF1ZCI6ImV4YW1wbGUuY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDB9.YuCVuC6JA4RPedAfH6bt3zTP0iB7hwMdDbgsWA9z8AM4HEcOpzE0OghcTlo6xuS4FcifI9fl_rfZQjCtDh7p2LUxn0vdKT0oFlecaDRxu8PEx9CV8zS6h7oYKE6p3gMx0MMIzNTWIY7jOKBLSQInygA3Jv_xXAH22zoUaif10Xg');
        $jwt->get('name');
    }

}