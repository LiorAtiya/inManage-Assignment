<?php

require 'connectionDB.php';

$apiUrl = 'https://jsonplaceholder.typicode.com/users';

$response = file_get_contents($apiUrl);

if ($response !== false) {
    $data = json_decode($response, true); 
    print_r($data);
} else {
    echo 'Failed to fetch data from the API';
}
