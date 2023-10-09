<?php
include 'database.php';

$db_mysql = new Database();
$db_mysql->connect();

// create tables of users & posts
function create_users_and_posts_tables()
{
    global $db_mysql;
    $result = $db_mysql->create_users_table();
    if ($result !== false) {
        echo "Creating the users table was successful <br>";
    }else {
        echo "Failed to create users table  <br>";
    }

    $result = $db_mysql->create_posts_table();
    if ($result !== false) {
        echo "Creating the posts table was successful <br>";
    }else {
        echo "Failed to create posts table <br>";
    }

}

// insert info from fake REST api
function insert_info_to_users_and_posts()
{
    global $db_mysql;
    $apiUrl = 'https://jsonplaceholder.typicode.com/users';

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    } else {
        curl_close($ch);

        $data = json_decode($response, true);

        if ($data !== null) {

            $fieldsArray = ["id", "name", "email", "active"];
            $fields2Array = ["user_id", "title", "content", "creation_date", "active"];

            foreach ($data as $user) {
                $valuesArray = [$user['id'], $user['name'], $user['email'], (bool) rand(0, 1)];
                $db_mysql->insert_users("users", $fieldsArray, $valuesArray);

                $id = $user['id'];

                $apiUrl = "https://jsonplaceholder.typicode.com/users/$id/posts";

                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'cURL error: ' . curl_error($ch) .' <br>';
                } else {
                    curl_close($ch);

                    $data = json_decode($response, true);

                    foreach ($data as $post) {
                        $valuesArray = [$post['userId'], $post['title'], $post['body'], null, (bool) rand(0, 1)];
                        $db_mysql->insert_posts("posts", $fields2Array, $valuesArray);
                    }
                }
            }
            echo 'Inserting information from the Fake REST API was successful  <br>';
        } else {
            echo 'JSON decoding error  <br>';
        }
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
            echo "Image saved successfully to avatar.jpg  <br>";
        } else {
            echo "Failed to save the image to avatar.jpg  <br>";
            // var_dump(error_get_last());
        }
    }
}


// Add new column of birthday to users and update all rows with random birthday of users
function fill_birthday_column()
{
    global $db_mysql;
    $result = $db_mysql->add_column("users", "birthday", "DATE");
    if ($result !== false) {
        echo "Adding a birthday column was successful  <br>";
    }else {
        echo "Failed to add birthday column  <br>";
    }

    for ($i = 1; $i < 11; $i++) {
        $db_mysql->update_row("users", "birthday", "1996-$i-1", "id = $i");
    }
    echo "Filling the birthday column randomly was successful  <br>";
}
