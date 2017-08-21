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
 * $privateKey  mixed  the key used to sign the token (path or actual key)
 */
$token = JWT::encode($payload, $privateKey);
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
	$payload = $jwt->decode($publicKey);
	```
