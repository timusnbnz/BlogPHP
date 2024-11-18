<?php
require_once('config.php');
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindung fehlgeschlagen: " . $e->getMessage());
}

// SQL-Abfrage, um die Posts nach Themen gruppiert und nach Erstellungsdatum sortiert abzurufen
$sql = "
    SELECT themes.name AS theme_name, posts.id AS post_id, posts.title, posts.content, posts.created_at, users.username
    FROM posts
    JOIN themes ON posts.theme_id = themes.id
    JOIN users ON posts.user_id = users.id
    ORDER BY themes.name, posts.created_at DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

// Array, um Posts nach Themen zu gruppieren
$groupedPosts = [];

foreach ($posts as $post) {
    $themeName = $post['theme_name'];
    $groupedPosts[$themeName][] = $post;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts nach Themen gruppiert</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php
    require_once('suchleiste.php');
    ?>
    <div class="bg-gray-100 text-gray-800 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Blog Posts nach Themen</h1>

        <?php foreach ($groupedPosts as $theme => $posts): ?>
            <div class="mb-6">
                <h2 class="text-3xl font-semibold text-indigo-600 mb-4"><?php echo htmlspecialchars($theme); ?></h2>
                <?php foreach ($posts as $post): ?>
                    <div class="bg-white shadow-md rounded-lg p-6 mb-4 border border-gray-200">
                        <h3 class="text-2xl font-semibold text-gray-800"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="text-gray-600 mt-4"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <p class="text-sm text-gray-500 mt-4">
                            <em>Verfasst von <span class="font-semibold"><?php echo htmlspecialchars($post['username']); ?></span> am 
                            <?php echo htmlspecialchars($post['created_at']); ?></em>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
</body>
</html>
