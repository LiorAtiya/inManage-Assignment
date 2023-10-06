<?php

require_once 'db_connection.php';

$conn = databaseConnection();

$apiUrl = 'https://jsonplaceholder.typicode.com/users';
$response = file_get_contents($apiUrl);

if ($response !== false) {
    $data = json_decode($response, true);

    foreach ($data as $user) {

        // $stmt = $conn->prepare("INSERT INTO users (id, name, email, active) VALUES (?, ?, ?, ?)");

        $id = $user['id'];
        $name = $user['name'];
        $email = $user['email'];
        $randomActive = (bool) rand(0, 1);

        // $stmt->bind_param("issi",$id, $name, $email, $randomActive);
        // $stmt->execute();

        $apiUrl = "https://jsonplaceholder.typicode.com/users/$id/posts";
        $response = file_get_contents($apiUrl);

        $data = json_decode($response, true);
        foreach ($data as $post) {

            $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, creation_date, active) VALUES (?, ?, ?, ?, ?)");

            $user_id = $post['userId'];
            $title = $post['title'];
            $content = $post['body'];
            $creation_date = null;
            $randomActive = (bool) rand(0, 1);

            $stmt->bind_param("isssi", $user_id, $title, $content, $creation_date, $randomActive);
            $stmt->execute();
        }
    }
} else {
    echo 'Failed to fetch data from the API';
}
