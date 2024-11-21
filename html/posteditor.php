<?php
require_once('config.php');
$title = $content = $theme_id = "";
$title_err = $content_err = $theme_id_err = "";
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :post_id");
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($post) {
        $title = $post['title'];
        $content = $post['content'];
        $theme_id = $post['theme_id'];
    } else {
        echo "Post nicht gefunden.";
        exit;
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $theme_id = $_POST['theme_id'];
        if (empty($title)) {
            $title_err = "Titel ist erforderlich.";
        }
        if (empty($content)) {
            $content_err = "Inhalt ist erforderlich.";
        }
        if (empty($theme_id)) {
            $theme_id_err = "Thema ist erforderlich.";
        }
        if (empty($title_err) && empty($content_err) && empty($theme_id_err)) {
            $insert_stmt = $pdo->prepare("INSERT INTO posts (title, content, theme_id) VALUES (:title, :content, :theme_id)");
            $insert_stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $insert_stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $insert_stmt->bindParam(':theme_id', $theme_id, PDO::PARAM_INT);
            if ($insert_stmt->execute()) {
                echo "Neuer Post wurde erfolgreich erstellt.";
            } else {
                echo "Fehler beim Erstellen des Posts.";
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    if (empty($title_err) && empty($content_err) && empty($theme_id_err)) {
        $update_stmt = $pdo->prepare("UPDATE posts SET title = :title, content = :content, theme_id = :theme_id WHERE id = :post_id");
        $update_stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $update_stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $update_stmt->bindParam(':theme_id', $theme_id, PDO::PARAM_INT);
        $update_stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        if ($update_stmt->execute()) {
            echo "Post wurde erfolgreich aktualisiert.";
        } else {
            echo "Fehler beim Aktualisieren des Posts.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post bearbeiten</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <h1 class="text-2xl font-bold text-center text-gray-800"><?php echo isset($_GET['id']) ? 'Post bearbeiten' : 'Neuen Post erstellen'; ?></h1>
        <form action="" method="post">
            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700">Titel:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <span class="text-red-500"><?php echo $title_err; ?></span>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-lg font-medium text-gray-700">Inhalt:</label>
                <textarea name="content" id="content" class="mt-1 p-2 w-full h-40 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"><?php echo htmlspecialchars($content); ?></textarea>
                <span class="text-red-500"><?php echo $content_err; ?></span>
            </div>
            <div class="mb-4">
                <label for="theme_id" class="block text-lg font-medium text-gray-700">Thema:</label>
                <input type="number" name="theme_id" id="theme_id" value="<?php echo htmlspecialchars($theme_id); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <span class="text-red-500"><?php echo $theme_id_err; ?></span>
            </div>
            <div class="mb-4 text-center">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">Absenden</button>
            </div>
        </form>
    </div>
</body>

</html>