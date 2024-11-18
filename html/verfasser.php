<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer-Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php
require_once('suchleiste.php');
?>
    <div class="bg-gray-100 text-gray-800 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Beiträge des Nutzers</h1>
        <?php
        // Datenbankverbindung herstellen
        require_once('config.php');

        // Nutzer-ID (z. B. aus GET-Parametern)
        $user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
        if (!$user_id) {
            $error = "Ungültige Nutzer-ID";
        }

        // Beiträge abrufen
        $stmt = $pdo->prepare("
            SELECT * 
            FROM posts 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Beiträge anzeigen
        if (count($posts) > 0) {
            foreach ($posts as $post) {
                echo "<div class='bg-white shadow-md rounded-lg p-6 mb-6'>";
                echo "<h2 class='text-2xl font-semibold text-gray-700'>" . htmlspecialchars($post['title']) . "</h2>";
                echo "<p class='text-gray-600 mt-4'>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
                echo "<small class='block text-gray-400 mt-4'>Erstellt am: " . htmlspecialchars($post['created_at']) . "</small>";
                echo "</div>";
            }
        } else {
            echo "<div class='text-gray-500 text-center bg-gray-200 p-4 rounded'>Keine Beiträge von diesem Nutzer gefunden.</div>";
        }
        ?>
        <?php if (!empty($error)) : ?>
                <div class="bg-red-500 text-white font-semibold py-2 px-4 my-4 rounded-md shadow-md">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
    </div>
    </div>
</body>
</html>