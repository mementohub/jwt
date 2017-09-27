### The test token payload structure

The data structure to use when generating a test token with `Guard::generateTestToken($config, $data)`.

```php
$data = [
    'iss' => 'issuer',
    'perms' => [
        'iss' => 'perms',
        'cns' => 'test',
        'srv' => 'destinations',
        'roles' => [
            'ua' => ['user'],
            'cns' => ['admin'],
        ],
        'user' => [
            'iss' => 'auth',
            'uid' => 1,
            'aid' => 1,
        ]
    ]
];
```