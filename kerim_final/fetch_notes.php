<?php
include 'config.php';
session_start();

header('Content-Type: application/json');

$sql = "SELECT id, username, title, note, likes, dislikes, date FROM notes";
$result = $conn->query($sql);

$notes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notes[] = [
            'id' => $row['id'],
            'username' => htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'),
            'title' => htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'),
            'note' => htmlspecialchars($row['note'], ENT_QUOTES, 'UTF-8'),
            'likes' => intval($row['likes']),
            'dislikes' => intval($row['dislikes']),
            'date' => htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8')
        ];
    }
}

echo json_encode($notes);
?>
