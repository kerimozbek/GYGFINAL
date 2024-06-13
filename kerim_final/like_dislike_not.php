<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $note_id = intval($_POST['note_id']);
    $action = $_POST['action'];

    $stmt = $conn->prepare("SELECT is_like FROM likes WHERE user_id = ? AND note_id = ?");
    $stmt->bind_param("ii", $user_id, $note_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($is_like);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        $new_is_like = $action == 'like';
        $stmt = $conn->prepare("UPDATE likes SET is_like = ? WHERE user_id = ? AND note_id = ?");
        $stmt->bind_param("iii", $new_is_like, $user_id, $note_id);
        $stmt->execute();
    } else {
        $is_like = $action == 'like';
        $stmt = $conn->prepare("INSERT INTO likes (user_id, note_id, is_like) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $note_id, $is_like);
        $stmt->execute();
    }

    $stmt = $conn->prepare("UPDATE notes SET likes = likes + ?, dislikes = dislikes + ? WHERE id = ?");
    $like_increment = ($action == 'like') ? 1 : -1;
    $dislike_increment = ($action == 'like') ? -1 : 1;
    $stmt->bind_param("iii", $like_increment, $dislike_increment, $note_id);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT likes, dislikes FROM notes WHERE id = ?");
    $stmt->bind_param("i", $note_id);
    $stmt->execute();
    $stmt->bind_result($likes, $dislikes);
    $stmt->fetch();

    echo json_encode(["status" => "success", "likes" => $likes, "dislikes" => $dislikes]);

    $stmt->close();
    $conn->close();
}
?>
