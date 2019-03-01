<?php
/**
 * ATS TS Request example class
 */

use ATS\TS\Client;

require ('../src/Client.php');
require '../vendor/autoload.php';

$params = [
    'username' => null,
    'key' => null,
    'server' => null,
];

/**
 * Token expiration 1 month
 */

// For use cache
// $token = Cache::remember('token', 1000, function() use ($params) {
//     return Client::token($params);
// });

// Not use cache
$token = Client::token($params);

if ($token) {
    $client = new Client($token, $params);
    
    $response = $client->get('/session', [
        'fields' => 'id,performance.name',
        'expand' => 'performance',
    ]);
    
    print_r($response);
} else {
    echo "Error login";
}
