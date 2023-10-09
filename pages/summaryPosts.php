<?php

include __DIR__ . '/../includes/database.php';

$db_mysql = new Database();
$db_mysql->connect();

$result = $db_mysql->select_posts_count_summary();

if ($result->num_rows > 0) {
    echo '<div class="table">';
    echo '<div class="table-row header">';
    echo '<div class="table-cell">Publish Date</div>';
    echo '<div class="table-cell">Publish Time</div>';
    echo '<div class="table-cell">Post Count</div>';
    echo '</div>';
    while ($row = $result->fetch_assoc()) {

        echo '<div class="table-row">';
        echo '<div class="table-cell">' . $row['publish_date'] . '</div>';
        echo '<div class="table-cell">' . $row['publish_time'] . '</div>';
        echo '<div class="table-cell">' . $row['post_count'] . '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "No rows found.";
}
