<?php
include 'db.php';

$db = new Database("localhost", "url_short", "root", "");
$conn = $db->connect();

$stmt = $conn->query("SELECT * FROM urls");
$urls = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="main.css" />
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <lord-icon src="https://cdn.lordicon.com/vlycxjwx.json" trigger="hover" colors="primary:#121331,secondary:#320a5c" style="width:50px;height:50px"></lord-icon>
        <h1>URL Shortener</h1>
    </header>
    <main>
        <section class="form">
            <form action="/php-url-short-main/add/index.php" method="post">
                <input type="text" name="long_url" id="long_url" placeholder="Enter the URL here!" />
                <input type="submit" value="SHORTEN" />
            </form>
        </section>
        <section class="urls">
            <?php $counter = 1; ?>
            <?php foreach ($urls as $url) : ?>
            <div class="url">
                <div class="id">
                    <?= $counter++; ?>
                </div>
                <div class="short_url">
                    <a href="http://localhost/php-url-short-main/r?c=<?= $url['ID']; ?>" target="_blank">
                        http://localhost/php-url-short-main/r?c=<?= $url['ID']; ?>
                    </a>
                </div>
                <div class="copy_btn">
                    <button id="copy-btn-<?= $url['ID']; ?>" onclick="copyToClipboard('http://localhost/php-url-short-main/r?c=<?= $url['ID']; ?>')">
                        <i class='bx bx-copy-alt'></i> Copy
                    </button>
                </div>
                <div class="long_url">
                    <a href="<?= $url['long_url']; ?>" target="_blank"><?= $url['long_url']; ?></a>
                </div>
            </div>
            <?php endforeach; ?>
        </section>
    </main>
    <script>
        function copyToClipboard(url) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Copied to clipboard: ' + url);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</body>
</html>
