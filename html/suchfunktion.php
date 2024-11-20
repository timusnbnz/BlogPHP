<?php
require_once("config.php");


// Prüfen, ob die Suchanfrage übermittelt wurde
if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $query = htmlspecialchars(trim($_GET['query'])); // Eingabe bereinigen

    // SQL-Abfrage für die Suche nach Titel oder Autor
    $sql = "
        SELECT 
            posts.id AS post_id,
            posts.title,
            posts.content,
            users.username AS author,
            posts.created_at
        FROM 
            posts
        INNER JOIN users ON posts.user_id = users.id
        WHERE 
            posts.title LIKE :query OR 
            users.username LIKE :query
        ORDER BY posts.created_at DESC
    ";

    // SQL-Abfrage vorbereiten
    $stmt = $pdo->prepare($sql);
    $searchTerm = "%" . $query . "%";
    $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    // Ergebnisse abrufen
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // HTML-Struktur und Ergebnisse anzeigen
    echo "<!DOCTYPE html>";
    echo "<html lang='de'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<script src='https://cdn.tailwindcss.com'></script>";
    echo "<title>Suchergebnisse</title>";
    echo "</head>";
    echo "<body class='bg-gray-100'>";

    echo "<div class='container mx-auto px-4 py-4'>";
    if (count($result) > 0) {
        echo "<h1 class='text-2xl font-bold mb-4'>Suchergebnisse für: " . htmlspecialchars($query) . "</h1>";
        echo "<ul class='space-y-4'>";
        foreach ($result as $row) {
            echo "<li class='bg-white p-4 rounded shadow'>";
            echo "<h2 class='text-xl font-semibold text-blue-600'>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<p class='text-gray-700 mt-2'>" . htmlspecialchars(substr($row['content'], 0, 150)) . "...</p>";
            echo "<p class='text-sm text-gray-500 mt-2'>Von: " . htmlspecialchars($row['author']) . " | Erstellt am: " . htmlspecialchars($row['created_at']) . "</p>";
            echo "<a href='post.php?id=" . $row['post_id'] . "' class='text-blue-500 hover:underline'>Mehr lesen</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<h1 class='text-2xl font-bold'>Keine Ergebnisse gefunden.</h1>";
    }
    echo "</div>";

    echo "</body>";
    echo "</html>";
} else {
    // Fehlerseite bei leerem Suchfeld
    echo "<!DOCTYPE html>";
    echo "<html lang='de'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<script src='https://cdn.tailwindcss.com'></script>";
    echo "<title>Fehler</title>";
    echo "</head>";
    echo "<body class='bg-gray-100'>";

    echo "<div class='container mx-auto px-4 py-4'>";
    echo "<h1 class='text-2xl font-bold'>Bitte geben Sie einen Suchbegriff ein.</h1>";
    echo "<a href='index.php' class='text-blue-500 hover:underline'>Zurück zur Startseite</a>";
    echo "</div>";

    echo "</body>";
    echo "</html>";
}
?>