<?php

include 'db_connection.php';

$conn = databaseConnection();

echo '<h2 class="main-title">Birthday users of the month</h2>';

// $sql = "ALTER TABLE users ADD birthday DATE;";
// $result = $conn->query($sql);

// for ($i = 1 ; $i < 11 ; $i++) {
//     $sql =  "UPDATE users SET birthday = '1996-$i-1' WHERE id = $i;";
//     $result = $conn->query($sql);
// } 

$lastPost = "SELECT u.name, p.*
            FROM users u
            INNER JOIN posts p ON u.id = p.user_id
            WHERE MONTH(CURRENT_DATE()) = MONTH(u.birthday)
            ORDER BY p.creation_date DESC
            LIMIT 1;";

$result = $conn->query($lastPost);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="user-post">';
        echo '<div class="header-post">';
        echo '<img src="avatar.jpg" class="image" alt="avatar">';
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
