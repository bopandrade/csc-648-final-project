// Replace the database connection information, username and password with your own.
<?php
$conn = new PDO('mysql:dbname=charbuff;host=127.0.0.1', 'root', 'password');

$conn->exec('CREATE TABLE testIncrement ' .
            '(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50))');
$sth = $conn->prepare('INSERT INTO testIncrement (name) VALUES (:name)');
$sth->execute([':name' => 'foo']);
var_dump($conn->lastInsertId());
$conn->exec('DROP TABLE testIncrement');
?>
