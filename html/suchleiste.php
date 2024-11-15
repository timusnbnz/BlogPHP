<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Navbar mit Suchleiste</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Titel links -->
        <a href="index.php" class="text-2xl font-bold text-blue-600">MeineWebsite</a>

        <!-- Menü-Links in der Mitte -->
        <div id="menu" class="hidden md:flex space-x-6">
            <a href="index.php" class="text-gray-700 hover:text-blue-600">Home</a>
            <a href="about.php" class="text-gray-700 hover:text-blue-600">Über uns</a>
            <a href="services.php" class="text-gray-700 hover:text-blue-600">Dienstleistungen</a>
        </div>

        <!-- Suchleiste rechts -->
        <div class="hidden md:flex items-center">
            <form action="search.php" method="GET" class="relative">
                <input 
                    type="text" 
                    name="query" 
                    placeholder="Suche..." 
                    class="bg-gray-100 border border-gray-300 rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 1 0-12 0 6 6 0 0 0 12 0z" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Hamburger Button für mobile Geräte -->
        <button id="menu-btn" class="block md:hidden text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <!-- Mobiles Menü -->
    <div id="mobile-menu" class="md:hidden px-4 py-4 hidden">
        <a href="index.php" class="block py-2 text-gray-700 hover:text-blue-600">Home</a>
        <a href="about.php" class="block py-2 text-gray-700 hover:text-blue-600">Über uns</a>
        <a href="services.php" class="block py-2 text-gray-700 hover:text-blue-600">Dienstleistungen</a>
        <!-- Suchleiste für mobile Geräte -->
        <form action="search.php" method="GET" class="mt-4">
            <input 
                type="text" 
                name="query" 
                placeholder="Suche..." 
                class="w-full bg-gray-100 border border-gray-300 rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </form>
    </div>
</nav>

<!-- JavaScript für das mobile Menü -->
<script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

</body>
</html>
