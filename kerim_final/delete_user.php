<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM users WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kullanıcı Sil</title>
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

        p {
            font-size: 1.2em;
            line-height: 1.8;
            margin: 10px 0;
        }

        a, button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #ffcb05;
            color: #2b5876;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            border: none;
            font-weight: bold;
        }

        a:hover, button:hover {
            background-color: #ffb400;
            transform: scale(1.05);
        }

        .role {
            font-weight: bold;
            color: #ffcb05;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            max-width: 400px;
            margin: 20px auto;
        }

        form input {
            padding: 10px;
            border-radius: 8px;
            border: none;
            width: 100%;
        }

        footer {
            margin-top: auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            text-align: center;
            width: 100%;
            color: #f4f4f9;
        }

        footer a {
            color: #ffcb05;
            text-decoration: none;
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
            <li><a href="znk.php" role="button">Not Akışı</a></li>
            <li><a href="notyaz.php">Not Yaz</a></li>
            <li><a href="logout.php" role="button">Çıkış Yap</a></li>
        </ul>
    </nav>
    <main class="container">
        <h1>Kullanıcı Sil</h1>
        <form method="post" action="">
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" required>
            <button type="submit">Delete User</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Kerim Özbek. Tüm Hakları Saklıdır.</p>
    </footer>
</body>
</html>
