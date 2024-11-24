<?php
session_start();
?>
<html>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <script src='https://cdn.tailwindcss.com'></script>
    <title>Suchergebnisse</title>
</head>

<body class='bg-gray-100'>
    <? require_once('suchleiste.php'); ?>
    <div class="m-8 flex justify-center">
        <div class="w-full max-w-3xl">
            <?php
            require_once("config.php");

            if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
                $query = htmlspecialchars(trim($_GET['query']));
                $stmt = $pdo->prepare("SELECT id, title, created_at, content FROM posts WHERE title LIKE :query");
                $searchTerm = "%" . $query . "%";
                $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($results)) {
                    echo "<ul class='w-full'>";
                    foreach ($results as $post) {
                        echo "<a href='postviewer.php?id=" . $post['id'] . "'><li class='bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow m-4'>";
                        echo "<h1 class='text-3xl font-bold text-gray-800 mb-4'>" . htmlspecialchars($post['title']) . "</h1>";
                        echo "<p class='text-gray-700 mt-2'>" . htmlspecialchars(substr($post['content'], 0, 150)) . "</p>";
                        echo "<p class='text-sm text-gray-500 mt-4'>Erstellt am: " . htmlspecialchars($post['created_at']) . "</p></li></a>";
                    }
                    echo "</ul>";
                } else {
                    echo "<div class='text-center bg-red-100 text-red-600 p-4 rounded-lg mt-6 w-full'><p class='text-lg'>Keine Ergebnisse gefunden.</p></div>";
                }
            }

            ?>
        </div>
    </div>
</body>

</html>