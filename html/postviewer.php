<?php
session_start();
require_once("config.php");
$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$title = $content = $timestamp = '';

if ($postId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT id, title, content, created_at, views FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            $newViewsCount = $post['views'] + 1;

            $updateStmt = $pdo->prepare("UPDATE posts SET views = :views WHERE id = :id");
            $updateStmt->bindParam(':views', $newViewsCount, PDO::PARAM_INT);
            $updateStmt->bindParam(':id', $postId, PDO::PARAM_INT);
            $updateStmt->execute();

            $title = htmlspecialchars($post['title']);
            $timestamp = htmlspecialchars($post['created_at']);
            $content = htmlspecialchars($post['content']);
        } else {
            $error = "Artikel nicht gefunden";
        }
    } catch (PDOException $e) {
        $error =  "Fehler bei der Abfrage: " . htmlspecialchars($e->getMessage());
    }
} else {
    $error = "Ungültige Artikel-ID";
}
?>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog-Artikel ansehen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body class="min-h-full bg-gray-100">
    <?php
    require_once 'suchleiste.php';
    ?>
    <div class="flex justify-center items-center">
        <div class="container mx-auto m-8">
            <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
                <h1 class='text-3xl font-bold text-gray-800 m-4'><?= $title ?></h1>
                <p class='text-sm text-gray-500 mx-4'>Erstellt: <?= $timestamp ?>, Ansichten: <?= $newViewsCount; ?></p>
                <div class='prose max-w-none m-4'><?= $content ?></div>
                <?php
                if (isset($_SESSION['userid'])) {
                    echo '<a href="comment.php?postid=' . $postId . '"><button type="button" class="m-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Kommentieren</button></a>';
                    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mod') {
                        echo '<a href="posteditor.php?id=' . $postId . '"><button type="button" class="m-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Bearbeiten</button></a>';
                        echo '<a href="delete.php?id=' . $postId . '"><button type="button" class="m-2 bg-red-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Löschen</button></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </div>
    <div class="container mx-auto p-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-6 space-y-4">
            <?php
            $stmt = $pdo->prepare("SELECT comments.id, comments.userId, comments.content, comments.created, users.username FROM comments JOIN users ON comments.userId = users.id WHERE comments.postId = :postId ORDER BY comments.created DESC");
            $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($comments) {
                echo "<h3 class='text-xl font-semibold text-gray-800'>Kommentare:</h3>";
                foreach ($comments as $comment) {
                    echo "<div class='border-t pt-4'><p class='font-medium text-gray-900'>" . htmlspecialchars($comment['username']) . " <small class='text-sm text-gray-500'> " . $comment['created'] . "</small></div></p>";
                    echo "<p class='mt-2 text-gray-700'>" . nl2br(htmlspecialchars($comment['content'])) . "</p>";
                    if (isset($_SESSION['userid'])) {
                        if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mod' || $_SESSION['userid'] == $comment['userId']) {
                            echo '<a href="deletecomment.php?id=' . $comment['id'] . '" class="text-red-500 hover:text-blue-600">Löschen</a>';
                        }
                    }
                }
            } else {
                echo "<p class='text-gray-500'>Keine Kommentare für diesen Beitrag.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>