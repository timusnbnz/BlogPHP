<?php
session_start();
?>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Startseite</title>
</head>

<body class="min-h-full bg-gray-100 ">
    <?php
    require_once 'suchleiste.php';
    ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Willkommen auf unserem Blog!</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Neueste Artikel -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Neueste Artikel</h2>
                <?php
                require_once("config.php");

                try {
                    // Verbindung zur Datenbank herstellen
                    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Neueste Artikel abrufen
                    $stmtNewest = $pdo->query("
                    SELECT id, title, created_at 
                    FROM posts 
                    ORDER BY created_at DESC 
                    LIMIT 5
                ");

                    while ($post = $stmtNewest->fetch(PDO::FETCH_ASSOC)) {
                        echo "
                        <div class='mb-4'>
                            <a href='article.php?id=" . htmlspecialchars($post['id']) . "' class='text-xl font-semibold text-blue-600 hover:underline'>
                                " . htmlspecialchars($post['title']) . "
                            </a>
                            <p class='text-sm text-gray-500'>Erstellt am " . htmlspecialchars($post['created_at']) . "</p>
                        </div>
                    ";
                    }
                } catch (PDOException $e) {
                    echo "<p class='text-red-500'>Fehler beim Laden der neuesten Artikel: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </div>

            <!-- Meistgelikte Artikel -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Beliebteste Artikel</h2>
                <?php
                try {
                    // Meistgelikte Artikel abrufen
                    $stmtPopular = $pdo->query("
                    SELECT p.id, p.title, COUNT(l.post_id) AS like_count 
                    FROM posts p
                    LEFT JOIN likes l ON p.id = l.post_id
                    GROUP BY p.id
                    ORDER BY like_count DESC 
                    LIMIT 5
                ");

                    while ($post = $stmtPopular->fetch(PDO::FETCH_ASSOC)) {
                        echo "
                        <div class='mb-4'>
                            <a href='article.php?id=" . htmlspecialchars($post['id']) . "' class='text-xl font-semibold text-blue-600 hover:underline'>
                                " . htmlspecialchars($post['title']) . "
                            </a>
                            <p class='text-sm text-gray-500'>" . htmlspecialchars($post['like_count']) . " Likes</p>
                        </div>
                    ";
                    }
                } catch (PDOException $e) {
                    echo "<p class='text-red-500'>Fehler beim Laden der beliebtesten Artikel: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>