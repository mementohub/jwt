## Our custom JWT wrapper
It can be required anywhere is needed to work with JWT. It is framework independent.

### Install
Require this package with composer using the following command:
```bash
composer require imemento/jwt
```

### Usage

##### Encoding
To encode a JWT just use the `encode` static method:
```php
JWT::encode($payload, $privateKey, $alg);
```
`$payload` must be object/array. `$privateKey` is the path to a OpenSSL private key or a secret hash. `$alg` is the optional algorithm and defaults to 'RS256'. Check out https://github.com/firebase/php-jwt for more options.

##### Decoding
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