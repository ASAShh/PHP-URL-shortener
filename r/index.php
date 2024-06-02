<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db.php';

$db = new Database("localhost", "url_short", "root", "");
$conn = $db->connect();

if (!$conn) {
    die("Connection failed: Unable to connect to the database.");
}

if (isset($_GET['c']) && is_numeric($_GET['c'])) {
    $id = intval($_GET['c']);

    try {
        $query = "SELECT * FROM urls WHERE ID = :ID LIMIT 1";
        $stmt = $conn->prepare($query);

        $params = array(
            "ID" => $id
        );

        $stmt->execute($params);

        $url = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($url) {
            header("Location: " . $url['long_url']);
            exit();
        } else {
            echo "URL not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid URL.";
}
?>
