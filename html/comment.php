<?php
session_start();
require_once('config.php');
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}
//Weil PHP sonst am yappen is Teil 2
$content = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['postid'])) {
    $postId = $_GET['postid'];
    $content = $_POST['content'];
    $userId = $_SESSION['userid'];

    if (empty($content)) {
        $error = "Inhalt ist erforderlich.";
    }
    if (empty($postId)) {
        $error = "Zugehöriger Post erforderlich";
    }
    if (empty($error)) {
        $insert_stmt = $pdo->prepare("INSERT INTO comments (postId, userId, content) VALUES (:postId, :userId, :content)");
        $insert_stmt->bindParam(':postId', $postId, PDO::PARAM_STR);
        $insert_stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $insert_stmt->bindParam(':content', $content, PDO::PARAM_STR);

        if ($insert_stmt->execute()) {
            header("Location: postviewer.php?id=".$postId);
        } else {
            $error =  "Fehler beim erstellen des Kommentars";
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
        <h1 class="text-2xl font-bold text-center text-gray-800">Kommentar verfassen</h1>
        <form action="" method="post">
            <div class="mb-4">
                <label for="content" class="block text-lg font-medium text-gray-700">Kommentar</label>
                <textarea name="content" id="content" class="mt-1 p-2 w-full h-40 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"><?php echo htmlspecialchars($content); ?></textarea>
            </div>
            <div class="mb-4 text-center">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">Absenden</button>
            </div>
        </form>
    </div>
</body>

</html>