# iMemento JWT Wrapper

A custom JWT Wrapper to be used in iMemento projects.
It uses the **RS256** algorithm and it is framework independent.

## Install
```bash
composer require imemento/jwt
```

## Usage
```php
use iMemento\JWT\JWT;
```

### Encoding
To encode a JWT just use the `encode` static method:
```php
/**
 * $payload object/array
 * $privateKey mixed the key used to sign the token
 */
$token = JWT::encode($payload, $private_key);
```

### Decoding
To decode a JWT we must follow the next steps.

1. Instantiate the class with the token we want to decode:
	```php
	$jwt = new JWT($token);
	```

2. Get the issuer before checking the signature (used to find the correct public key):
	```php
	$issuer = $jwt->getIssuer();
	```

3. Get the payload and check the signature at the same time:
	```php
	$payload = $jwt->decode($public_key);
	```

### Additional Classes
*Guard.php* - Decrypts the token and is used to extract the permissions from it.

*Issuer.php* - Represents the current application.

*Payload.php* - Is used to create a standard payload for the JWT.

[Test Token Data Structure](test-token.md)