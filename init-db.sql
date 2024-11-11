-- Tabelle für Nutzer
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Benutzer-ID
    username VARCHAR(255) NOT NULL UNIQUE,      -- Benutzername
    email VARCHAR(255) NOT NULL UNIQUE,         -- E-Mail-Adresse
    password VARCHAR(255) NOT NULL,             -- Passwort (normalerweise verschlüsselt speichern)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Erstellungsdatum
);

-- Tabelle für Themen
CREATE TABLE IF NOT EXISTS themes (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Thema-ID
    name VARCHAR(255) NOT NULL UNIQUE           -- Thema-Name (z. B. "Tech", "Sport")
);

-- Tabelle für Posts
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Post-ID
    user_id INT NOT NULL,                      -- Verfasser des Posts (Verknüpfung zur Users-Tabelle)
    title VARCHAR(255) NOT NULL,                -- Post-Titel
    content TEXT NOT NULL,                     -- Inhalt des Posts
    theme_id INT NOT NULL,                     -- Zugehöriges Thema (Verknüpfung zur Themes-Tabelle)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Erstellungsdatum des Posts
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,  -- Beziehung zu Users
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE -- Beziehung zu Themes
);

-- Tabelle für Kommentare
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Kommentar-ID
    post_id INT NOT NULL,                       -- Zugehöriger Post (Verknüpfung zur Posts-Tabelle)
    user_id INT NOT NULL,                       -- Verfasser des Kommentars (Verknüpfung zur Users-Tabelle)
    content TEXT NOT NULL,                      -- Inhalt des Kommentars
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Erstellungsdatum des Kommentars
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE, -- Beziehung zu Posts
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE  -- Beziehung zu Users
);