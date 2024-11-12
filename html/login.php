<?php
session_start();
require_once 'config.php';
if (isset($_SESSION['userid'])) {
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_email = trim($_POST['email']);
    $user_password = trim($_POST['password']);

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {     //Verbindung kaputt :(
        die("Verbindung fehlgeschlagen: " . $e->getMessage());
    }

    $sql = "SELECT id, username, email, password FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($user_password, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            header("Location: index.php");
        } else {
            $error = "Falsches Passwort.";
        }
    } else {
        $error = "Kein Benutzer mit dieser E-Mail-Adresse gefunden.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Formular</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login</h2>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-600 font-medium mb-2">E-Mail-Adresse</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" required placeholder="E-Mail eingeben">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-600 font-medium mb-2">Passwort</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" required placeholder="Passwort eingeben">
            </div>
            <div class="mb-4">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Anmelden
                </button>
            </div>
            <?php
            if (!empty($error)) echo '<div class="bg-red-500 text-white font-semibold py-2 px-4 my-4 rounded-md shadow-md">' . htmlspecialchars($error) . '</div>';
            ?>
            <div class="text-center">
                <a href="register.php" class="text-indigo-600 hover:text-indigo-700 text-sm">Noch kein Konto?</a>
            </div>
        </form>
    </div>
</body>

</html>