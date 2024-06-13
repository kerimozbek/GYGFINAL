<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET username='$username', role='$role' WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully";
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
    <title>Kullanıcı Güncelle</title>
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        input[type="number"],
        input[type="text"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="number"]:focus,
        input[type="text"]:focus,
        select:focus {
            border-color: #ffcb05;
            box-shadow: 0 0 5px rgba(255, 203, 5, 0.5);
            outline: none;
        }

        button {
            padding: 12px 24px;
            background-color: #ffcb05;
            color: #2b5876;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #ffb400;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        <h1>Kullanıcı Güncelle</h1>
        <form method="post" action="">
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" required>
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
            <label for="role">Rol:</label>
            <select id="role" name="role">
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
                <option value="user">User</option>
            </select>
            <button type="submit">Update User</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Kerim Özbek. Tüm Hakları Saklıdır.</p>
    </footer>
</body>
</html>
