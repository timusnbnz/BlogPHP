<?php
// Seite zur Registrierung
// E-Mail und Passwort Verifizieren
// Passwort gehashed in Datenbank speichern
// Prüfen ob E-Mail oder Nutzername bereits vorhanden
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrieren</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-96">
    <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Registrieren</h2>
    <form action="#" method="POST">
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
      <div class="text-center">
        <a href="login.php" class="text-indigo-600 hover:text-indigo-700 text-sm">Bereits ein Konto?</a>
      </div>
    </form>

  </div>

</body>
</html>
