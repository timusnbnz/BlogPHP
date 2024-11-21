<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
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
    <title>Accounteinstellungen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body class="min-h-full bg-gray-100">
    <?php
    require_once 'suchleiste.php';
    ?>
    <div class="flex items-center justify-center p-6">
        <div class="max-w-lg w-full bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Kontoeinstellungen</h2>

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

            <!-- Benutzername -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-gray-700 font-medium">Benutzername</h3>
                    <p class="text-gray-500">Aktueller Benutzername: <strong><?= htmlspecialchars($user['username']) ?></strong></p>
                </div>
                <button type="button" onclick="toggleField('username')" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                    Ändern
                </button>
            </div>
            <form method="POST" id="username-form" class="hidden mb-6">
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" placeholder="Neuer Benutzername" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" />
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg">Speichern</button>
            </form>

            <!-- E-Mail -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-gray-700 font-medium">E-Mail</h3>
                    <p class="text-gray-500">Aktuelle E-Mail: <strong><?= htmlspecialchars($user['email']) ?></strong></p>
                </div>
                <button type="button" onclick="toggleField('email')" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                    Ändern
                </button>
            </div>
            <form method="POST" id="email-form" class="hidden mb-6">
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Neue E-Mail" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" />
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg">Speichern</button>
            </form>

            <!-- Passwort -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-gray-700 font-medium">Passwort</h3>
                </div>
                <button type="button" onclick="toggleField('password')" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                    Ändern
                </button>
            </div>
            <form method="POST" id="password-form" class="hidden">
                <input type="password" name="new_password" placeholder="Neues Passwort" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" />
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg">Speichern</button>
            </form>
            <a href="logout.php">
                <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                    Abmelden
                </button>
            </a>
        </div>
    </div>

    <script>
        function toggleField(field) {
            const form = document.getElementById(`${field}-form`);
            form.classList.toggle('hidden');
        }
    </script>
</body>


</html>