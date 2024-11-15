<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog-Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <?php
        require_once("config.php");

        try {
            // Verbindung zur Datenbank herstellen
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("<p class='text-red-500'>Datenbankverbindung fehlgeschlagen: " . htmlspecialchars($e->getMessage()) . "</p>");
        }

        // Abfrageparameter (Artikel-ID aus URL-Parameter, z. B. ?id=1)
        $postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($postId > 0) {
            try {
                // SQL-Abfrage, um den Artikel zu holen
                $stmt = $pdo->prepare("
                    SELECT 
                        id, 
                        title, 
                        content, 
                        created_at 
                    FROM posts 
                    WHERE id = :id
                ");
                $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
                $stmt->execute();

                // Artikel abrufen
                $post = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($post) {
                    // Artikel anzeigen
                    echo "<h1 class='text-3xl font-bold text-gray-800 mb-4'>" . htmlspecialchars($post['title']) . "</h1>";
                    echo "<p class='text-sm text-gray-500 mb-6'>Erstellt am " . htmlspecialchars($post['created_at']) . "</p>";
                    echo "<div class='prose max-w-none'>" . nl2br(htmlspecialchars($post['content'])) . "</div>";
                } else {
                    echo "<p class='text-red-500'>Artikel nicht gefunden.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='text-red-500'>Fehler bei der Abfrage: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            echo "<p class='text-red-500'>Ungültige Artikel-ID.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>