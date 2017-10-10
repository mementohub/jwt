<?php

/*
|--------------------------------------------------------------------------
| The paths to the encryption keys
|--------------------------------------------------------------------------
|
| Here you may specify the paths to both the production and the test
| encryption keys.
|
*/

return [

    'private' => env('PRIVATE_KEY', base_path('keys/private/id_rsa')),

    'public' => [
        'auth' => env('PUBLIC_KEY_AUTH', base_path('keys/auth')),
        'perms' => env('PUBLIC_KEY_PERMS', base_path('keys/perms')),

        //TODO: public keys for every consumer here?
        //not sure if maintainable...

    ],

    'test' => [

        'private' => [
            'auth' => env('TEST_PRIVATE_KEY_AUTH', base_path('vendor/imemento/jwt/resources/test-keys/private-auth')),
            'perms' => env('TEST_PRIVATE_KEY_PERMS', base_path('vendor/imemento/jwt/resources/test-keys/private-perms')),
            'consumer' => env('TEST_PRIVATE_KEY_CONSUMER', base_path('vendor/imemento/jwt/resources/test-keys/private-consumer')),
        ],

        'public' => [
            'auth' => env('TEST_PUBLIC_KEY_AUTH', base_path('vendor/imemento/jwt/resources/test-keys/public-auth')),
            'perms' => env('TEST_PUBLIC_KEY_PERMS', base_path('vendor/imemento/jwt/resources/test-keys/public-perms')),
            'consumer' => env('TEST_PUBLIC_KEY_CONSUMER', base_path('vendor/imemento/jwt/resources/test-keys/public-consumer')),
        ],

    ],

];