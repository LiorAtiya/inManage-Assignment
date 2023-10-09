<?php
class Database
{

    private $connection;

    public function connect()
    {
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'in_manage';

        $conn = new mysqli($host, $user, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $this->connection = $conn;
    }

    public function create_users_table()
    {
        $sql = "
        CREATE TABLE users (
            id INT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            active BOOLEAN DEFAULT 1
        );";

        $this->connection->query($sql);
    }

    public function create_posts_table()
    {
        $sql = "
        CREATE TABLE posts (
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            active BOOLEAN DEFAULT 1,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );";
        $this->connection->query($sql);
    }

    public function select_posts_of_actives()
    {
        $sql = "SELECT * FROM users JOIN posts ON users.id = posts.user_id AND users.active = 1;";
        $result = $this->connection->query($sql);
        return $result;
    }

    public function select_posts_of_birthday_users()
    {
        $sql = "SELECT u.name, p.* FROM users u
            INNER JOIN posts p ON u.id = p.user_id
            WHERE MONTH(CURRENT_DATE()) = MONTH(u.birthday)
            ORDER BY p.creation_date DESC LIMIT 1;";

        $result = $this->connection->query($sql);
        return $result;
    }

    public function select_posts_count_summary()
    {
        $sql = "SELECT DATE(creation_date) AS publish_date,
            TIME(creation_date) AS publish_time,
            COUNT(*) AS post_count
            FROM posts
            GROUP BY publish_date, publish_time;";

        $result = $this->connection->query($sql);
        return $result;
    }

    public function add_column($table, $field, $type)
    {
        $sql = "ALTER TABLE $table ADD $field $type;";

        $result = $this->connection->query($sql);
        return $result;
    }

    public function update_row($table, $field, $newValue, $condition)
    {
        $sql =  "UPDATE $table SET $field = '$newValue' WHERE $condition;";

        $result = $this->connection->query($sql);
        return $result;
    }

    public function insert_users($table, $fieldsArray, $valuesArray)
    {
        
        $stmt = $this->connection->prepare("INSERT INTO $table ($fieldsArray[0], $fieldsArray[1], $fieldsArray[2], $fieldsArray[3]) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $valuesArray[0], $valuesArray[1], $valuesArray[2], $valuesArray[3]);
        $stmt->execute();
    }

    public function insert_posts($table, $fieldsArray, $valuesArray)
    {
        $stmt = $this->connection->prepare("INSERT INTO $table ($fieldsArray[0], $fieldsArray[1], $fieldsArray[2], $fieldsArray[3], $fieldsArray[4]) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $valuesArray[0], $valuesArray[1], $valuesArray[2], $valuesArray[3], $valuesArray[4]);
        $stmt->execute();
    }

    public function delete()
    {
    }
}
