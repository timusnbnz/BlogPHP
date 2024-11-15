<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit;
}

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = "Verbindung fehlgeschlagen: " . $e->getMessage();
    exit;
}

$userid = $_SESSION['userid'];
$query = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$query->execute([$userid]);
$user = $query->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? $user['username'];
    $email = $_POST['email'] ?? $user['email'];
    $new_password = $_POST['new_password'] ?? null;

    $checkUsername = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    $checkUsername->execute([$username, $userid]);
    $usernameExists = $checkUsername->fetch();

    if ($usernameExists) {
        $error = "Der Benutzername wird bereits verwendet.";
    } else {
        if (!empty($new_password)) {
            if (strlen($new_password) < 6) {
                $error = "Das Passwort muss mindestens 6 Zeichen lang sein.";
            } else {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update_password->execute([$password_hash, $userid]);
            }
        }
        if (empty($error)) {
            $update = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $update->execute([$username, $email, $userid]);
            $info = "Einstellungen wurden erfolgreich aktualisiert.";
        }
    }
}
?>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Einstellungen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-lg w-full bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Kontoeinstellungen</h2>
            <?php
            if (!empty($error)) echo '<div class="bg-red-500 text-white font-semibold py-2 px-4 my-4 rounded-md shadow-md">' . htmlspecialchars($error) . '</div>';
            ?>
            <?php
            if (!empty($info)) echo '<div class="bg-green-600 text-white font-semibold py-2 px-4 my-4 rounded-md shadow-md">' . htmlspecialchars($info) . '</div>';
            ?>
            <div class="mb-6">
                <h3 class="text-gray-700 font-medium">Benutzername</h3>
                <p class="text-gray-500 mb-4">Aktueller Benutzername: <strong><?= htmlspecialchars($user['username']) ?></strong></p>
                <form method="POST">
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" placeholder="Neuer Benutzername"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" />
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg">
                        Benutzername ändern
                    </button>
                </form>
            </div>
            <div class="mb-6">
                <h3 class="text-gray-700 font-medium">E-Mail</h3>
                <p class="text-gray-500 mb-4">Aktuelle E-Mail: <strong><?= htmlspecialchars($user['email']) ?></strong></p>
                <form method="POST">
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Neue E-Mail"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" />
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg">
                        E-Mail ändern
                    </button>
                </form>
            </div>
            <div class="mb-6">
                <h3 class="text-gray-700 font-medium">Passwort</h3>
                <form method="POST">
                    <input type="password" name="new_password" placeholder="Neues Passwort"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" />
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg">
                        Passwort ändern
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>