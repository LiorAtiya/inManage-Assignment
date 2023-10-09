<?php
include 'database.php';

$db_mysql = new Database();
$db_mysql->connect();

// create tables of users & posts
function create_users_and_posts_tables()
{
    global $db_mysql;
    $db_mysql->create_users_table();
    $db_mysql->create_posts_table();
}

// insert info from fake REST api
function insert_info_to_users_and_posts()
{
    global $db_mysql;
    $apiUrl = 'https://jsonplaceholder.typicode.com/users';
    $response = file_get_contents($apiUrl);

    if ($response !== false) {
        $data = json_decode($response, true);

        $fieldsArray = ["id", "name", "email", "active"];
        $fields2Array = ["user_id", "title", "content", "creation_date", "active"];

        foreach ($data as $user) {

            $valuesArray = [$user['id'], $user['name'], $user['email'], (bool) rand(0, 1)];
            $db_mysql->insert_users("users", $fieldsArray, $valuesArray);

            $id = $user['id'];

            $apiUrl = "https://jsonplaceholder.typicode.com/users/$id/posts";
            $response = file_get_contents($apiUrl);

            $data = json_decode($response, true);

            foreach ($data as $post) {

                $valuesArray = [$post['userId'], $post['title'], $post['body'], null, (bool) rand(0, 1)];
                $db_mysql->insert_posts("posts", $fields2Array, $valuesArray);
            }
        }
    } else {
        echo 'Failed to fetch data from the API';
        var_dump(error_get_last());
    }
}

// download profile image from url
function download_profile_image()
{
    $imageUrl = "https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg";
    $imageContent = file_get_contents($imageUrl);

    if ($imageContent === false) {
        echo "Failed to fetch the image.";
    } else {
        $result = file_put_contents(__DIR__ . "/../assets/images/avatar.jpg", $imageContent);
        if ($result !== false) {
            echo "Image saved successfully to image.jpg";
        } else {
            echo "Failed to save the image to image.jpg";
            var_dump(error_get_last());
        }
    }
}


// Add new column of birthday to users and update all rows with random birthday of users
function fill_birthday_column()
{
    global $db_mysql;
    $db_mysql->add_column("users", "birthday", "DATE");

    for ($i = 1; $i < 11; $i++) {
        $db_mysql->update_row("users", "birthday", "1996-$i-1", "id = $i");
    }
}
