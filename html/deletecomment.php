<?php
session_start();
require_once("config.php");
if (isset($_SESSION['userid'])) {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mod') {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                header("Location: index.php");
            }
        }
    }
}
