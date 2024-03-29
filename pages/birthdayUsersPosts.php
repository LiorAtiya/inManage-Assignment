<?php

include __DIR__ . '/../includes/database.php';

$db_mysql = new Database();
$db_mysql->connect();

$result = $db_mysql->select_posts_of_birthday_users();

if ($result->num_rows > 0) {

    $imagePath = '/inManage-Assignment/assets/images/avatar.jpg';

    while ($row = $result->fetch_assoc()) {
        echo '<div class="user-post">';
        echo '<div class="header-post">';
        echo '<img src="'. $imagePath . '" class="image" alt="avatar">';
        echo '<strong>' . $row['name'] . '</strong>';
        echo '</div>';
        echo '<p>' . $row['title'] . '</p>';
        echo '<hr>';
        echo '<p>' . $row['content'] . '</p>';
        echo '</div>';
    }
} else {
    echo "No active users found.";
}
