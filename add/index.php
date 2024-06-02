<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $long_url = $_POST['long_url'];

    // Validate URL format
    if (filter_var($long_url, FILTER_VALIDATE_URL)) {
        // Check if URL is reachable
        $ch = curl_init($long_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($response_code === 200) {
            // URL is valid and reachable, proceed with saving to the database
            $db = new Database("localhost", "url_short", "root", "");
            $conn = $db->connect();

            if ($conn) {
                $stmt = $conn->prepare("INSERT INTO urls (long_url) VALUES (:long_url)");
                $stmt->bindParam(':long_url', $long_url, PDO::PARAM_STR);
                $stmt->execute();

                header("Location: /php-url-short-main/index.php");
                exit;
            } else {
                echo "Failed to connect to the database.";
            }
        } else {
            echo "URL is not reachable or does not exist.";
        }
    } else {
        echo "Invalid URL format.";
    }
} else {
    echo "Invalid request method.";
}
?>
