<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['userid'])) {
    header("Location: index.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Bitte alle Felder ausfüllen.";
    }
    if ($password !== $confirm_password) {
        $error = "Passwörter stimmen nicht überein.";
    }

    if (empty($error)) {
        try {
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $error = "Verbindung fehlgeschlagen: " . $e->getMessage();
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->rowCount() > 0) {
            $error = "Nutzername bereits verwendet.";
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            $error = "E-Mail bereits verwendet.";
        }

        if (empty($error)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            if ($stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password])) {
                $info = "Registrierung erfolgreich!";

                $sql = "SELECT id FROM users WHERE email = :email LIMIT 1";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $user_email);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['userid'] = $user['id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                }
            } else {
                $error = "Fehler bei der Registrierung.";
            }
        }
    }
}
?>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php
    require_once 'suchleiste.php';
    ?>
    <div class="bg-gray-100 flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Registrieren</h2>
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-600 font-medium mb-2">Benutzername</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" required placeholder="Benutzernamen eingeben">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 font-medium mb-2">E-Mail-Adresse</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" required placeholder="E-Mail eingeben">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-600 font-medium mb-2">Passwort</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" required placeholder="Passwort eingeben">
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-600 font-medium mb-2">Passwort bestätigen</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" required placeholder="Passwort bestätigen">
                </div>
                <div class="mb-4">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Registrieren
                    </button>
                </div>
                <?php
                if (!empty($error)) echo '<div class="bg-red-500 text-white font-semibold py-2 px-4 my-4 rounded-md shadow-md">' . htmlspecialchars($error) . '</div>';
                ?>
                <?php
                if (!empty($info)) echo '<div class="bg-green-600 text-white font-semibold py-2 px-4 my-4 rounded-md shadow-md">' . htmlspecialchars($info) . '</div>';
                ?>
                <div class="text-center">
                    <a href="login.php" class="text-indigo-600 hover:text-indigo-700 text-sm">Bereits ein Konto?</a>
                </div>
            </form>
        </div>
    </div>

</html>