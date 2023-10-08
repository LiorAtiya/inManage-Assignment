<?php
include 'db_connection.php';

$conn = databaseConnection();

$sql = "SELECT * FROM users JOIN posts ON users.id = posts.user_id AND users.active = 1;";
$result = $conn->query($sql);

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
