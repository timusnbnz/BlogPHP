<?php
session_start();
require_once('config.php');
if (($_SESSION['role'] != 'admin') && ($_SESSION['role'] != 'mod')) {
    header("Location: index.php");
}
//Weil PHP sonst am yappen is
$title = $content = $error = "";
//Wenn bearbeiten will
if (isset($_GET['id'])) {
    if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'mod') {
        $error = 'Du hast keine Rechte!';
        die();
    }
    $postId = $_GET['id'];
    //Wenn man bearbeiten will
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :postId");
        $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            $title = $post['title'];
            $content = $post['content'];
        } else {
            $error = "Post nicht gefunden.";
            exit;
        }
    } else {
        //Wenn man bearbeitet hat
        $title = $_POST['title'];
        $content = $_POST['content'];
        if (empty($title)) {
            $error = "Titel ist erforderlich.";
        }
        if (empty($content)) {
            $error = "Inhalt ist erforderlich.";
        }
        if (empty($error)) {
            $update_stmt = $pdo->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :postId");
            $update_stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $update_stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $update_stmt->bindParam(':postId', $postId, PDO::PARAM_INT);

            if ($update_stmt->execute()) {
                $info = "Post wurde erfolgreich aktualisiert.";
            } else {
                $error = "Fehler beim Aktualisieren des Posts.";
            }
        }
    }
} else {
    //Wenn neuer Post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        if (empty($title)) {
            $error = "Titel ist erforderlich.";
        }
        if (empty($content)) {
            $error = "Inhalt ist erforderlich.";
        }
        if (empty($error)) {
            $insert_stmt = $pdo->prepare("INSERT INTO posts (title, content, userId) VALUES (:title, :content, :userId)");
            $insert_stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $insert_stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $insert_stmt->bindParam(':userId', $_SESSION['userid'], PDO::PARAM_STR);

            if ($insert_stmt->execute()) {
                $info = "Neuer Post wurde erfolgreich erstellt.";
            } else {
                $error =  "Fehler beim Erstellen des Posts.";
            }
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

<body class="bg-gray-100">
    <?php require_once("suchleiste.php"); ?>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <?php if (!empty($error)) : ?>
            <div class="bg-red-500 text-white font-semibold py-2 px-4 my-4 rounded-md shadow-md">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($info)) : ?>
            <div class="bg-green-600 text-white font-semibold py-2 px-4 my-4 rounded-md shadow-md">
                <?= htmlspecialchars($info) ?>
            </div>
        <?php endif; ?>
        <h1 class="text-2xl font-bold text-center text-gray-800"><?php echo isset($_GET['id']) ? 'Post bearbeiten' : 'Neuen Post erstellen'; ?></h1>
        <form action="" method="post">
            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700">Titel:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label for="content" class="block text-lg font-medium text-gray-700">Inhalt:</label>
                <textarea name="content" id="content" class="mt-1 p-2 w-full h-40 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"><?php echo htmlspecialchars($content); ?></textarea>
            </div>
            <div class="mb-4 text-center">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">Absenden</button>
            </div>
        </form>
    </div>
</body>

</html>