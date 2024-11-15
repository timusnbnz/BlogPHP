-- Tabelle für Nutzer
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Benutzer-ID
    username VARCHAR(255) NOT NULL UNIQUE,
    -- Benutzername
    email VARCHAR(255) NOT NULL UNIQUE,
    -- E-Mail-Adresse
    password VARCHAR(255) NOT NULL,
    -- Passwort (verschlüsselt)
    role_id INT DEFAULT 3,
    -- Standardrolle (z.B. "User" mit ID 3)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
);

-- Tabelle für Rollen
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Rollen-ID
    name VARCHAR(50) NOT NULL UNIQUE -- Rollenname (z.B. "Admin", "Moderator", "User")
);

-- Tabelle für Themen
CREATE TABLE IF NOT EXISTS themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Thema-ID
    name VARCHAR(255) NOT NULL UNIQUE -- Thema-Name (z. B. "Tech", "Sport")
);

-- Tabelle für Posts
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Post-ID
    user_id INT NOT NULL,
    -- Verfasser des Posts (Verknüpfung zur Users-Tabelle)
    title VARCHAR(255) NOT NULL,
    -- Post-Titel
    content TEXT NOT NULL,
    -- Inhalt des Posts
    theme_id INT NOT NULL,
    -- Zugehöriges Thema (Verknüpfung zur Themes-Tabelle)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Erstellungsdatum des Posts
);

-- Tabelle für Kommentare
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Kommentar-ID
    post_id INT NOT NULL,
    -- Zugehöriger Post (Verknüpfung zur Posts-Tabelle)
    user_id INT NOT NULL,
    -- Verfasser des Kommentars (Verknüpfung zur Users-Tabelle)
    content TEXT NOT NULL,
    -- Inhalt des Kommentars
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Erstellungsdatum des Kommentars
);

INSERT INTO
    roles (name)
VALUES
    ('Admin'),
    ('Moderator'),
    ('User');