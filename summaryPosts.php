<?php
    
    include 'db_connection.php';
    $conn = databaseConnection();

    $summary = "SELECT DATE(creation_date) AS publish_date,
            TIME(creation_date) AS publish_time,
            COUNT(*) AS post_count
            FROM posts
            GROUP BY publish_date, publish_time;";
    
    $result = $conn->query($summary);

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