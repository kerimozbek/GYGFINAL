<?php
include 'config.php';
session_start();

// Kullanıcının oturum açıp açmadığını kontrol edin
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$note = null;
$error = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['note_id'])) {
        // Fetch note details
        $note_id = $_POST['note_id'];
        $sql = "SELECT id, username, note, title, date 
                FROM notes 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $note_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $note = $result->fetch_assoc();
        } else {
            $error = "Girilen ID ile eşleşen not bulunamadı.";
        }
    } elseif (isset($_POST['confirm_delete'])) {
        // Delete note
        $note_id = $_POST['confirm_delete'];
        $sql = "DELETE FROM notes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $note_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Not başarıyla silindi.";
        } else {
            $error = "Not silme işlemi başarısız.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Not Sil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2b5876, #4e4376);
            color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        nav.container-fluid {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            margin: 20px 0;
            padding: 10px 20px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: #f4f4f9;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        nav ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        main.container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 700px;
            width: 90%;
            margin: 20px 0;
        }

        h1 {
            color: #ffcb05;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        .error {
            color: red;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="number"]:focus {
            border-color: #ffcb05;
            box-shadow: 0 0 5px rgba(255, 203, 5, 0.5);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #ffcb05;
            color: #2b5876;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #ffb400;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="container-fluid">
        <ul>
            <li><strong>Kerim Özbek</strong></li>
        </ul>
        <ul>
            <li><a href="dashboard.php">Yönetim Paneli</a></li>
            <li><a href="durt.php" role="button">Kullanıcı Dürt</a></li>
            <li><a href="notyaz.php">Not Yaz</a></li>
            <li><a href="znk.php" role="button">Not Akışı</a></li>
            <li><a href="notsil.php">Not Sil</a></li>
            <li><a href="logout.php" role="button">Çıkış Yap</a></li>
        </ul>
    </nav>
    <main class="container">
        <h1>Not Sil</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!$note): ?>
            <form method="POST" action="notsil.php">
                <label for="note_id">Not ID:</label>
                <input type="number" name="note_id" id="note_id" required>
                <button type="submit">Notu Getir</button>
            </form>
        <?php else: ?>
            <p>Not ID: <?php echo $note['id']; ?></p>
            <p>Kullanıcı Adı: <?php echo $note['username']; ?></p>
            <p>Başlık: <?php echo $note['title']; ?></p>
            <p>Not: <?php echo $note['note']; ?></p>
            <p>Tarih: <?php echo $note['date']; ?></p>
            <form method="POST" action="notsil.php">
                <input type="hidden" name="confirm_delete" value="<?php echo $note['id']; ?>">
                <button type="submit">Notu Sil</button>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
