<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username']; // Oturumdaki kullanıcı adı alınıyor
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $note = htmlspecialchars($_POST['note'], ENT_QUOTES, 'UTF-8');

    $stmt = $conn->prepare("INSERT INTO notes (username, title, note, date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $username, $title, $note);

    if ($stmt->execute()) {
        header("Location: notlistele.php");
    } else {
        echo "Hata: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>