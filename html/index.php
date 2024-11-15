<?php
session_start();
?>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Startseite</title>
</head>

<body>
    <?php
    require_once 'suchleiste.php';
    ?>
    <ul>
        <li><a href="account.php">Account</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="postviewer.php">Postviewer</a></li>
        <li><a href="register.php">Register</a></li>
    </ul>
</body>

</html>