<?php //Das übliche zeug laden
session_start();
require_once 'config.php';
//Leute raus schmeißen die bereits angemeldet sind
if (isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}
//Wenn über Form was rein kommt nh
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    //Digga füll erst mal alles aus bevor du abschickst
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Bitte alle Felder ausfüllen.";
    }
    //Bro bitte zwei mal das gleiche Passwort eingeben
    if ($password !== $confirm_password) {
        $error = "Passwörter stimmen nicht überein.";
    }
    //Alter wir wollen ein Passwort kein Passwitz
    if (strlen($password) < 8) {
        $error = "Das Passwort muss mind. 8 Zeichen haben";
    }
    if (empty($error)) {
        try {

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
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
                $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password, 'role' => 'user']);

                $_SESSION['userid'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 'user';

                header("Location: index.php");
            }
        } catch (PDOException $e) {
            $error = "Verbindung fehlgeschlagen: " . $e->getMessage();
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
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body class="min-h-full bg-gray-100 ">
    <?php
    require_once 'suchleiste.php';
    ?>
    <div class="flex justify-center items-center m-8">
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
</body>

</html>