<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kullanıcı Bul</title>
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

        h2, h3 {
            color: #ffcb05;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            gap: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus {
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

        .result {
            margin-top: 20px;
            text-align: left;
        }

        .result p {
            background: rgba(0, 0, 0, 0.2);
            padding: 10px;
            border-radius: 8px;
            margin: 5px 0;
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
            <li><a href="notlistele.php">Not Listele</a></li>
            <li><a href="notyaz.php">Not Yaz</a></li>
            <li><a href="logout.php" role="button">Çıkış Yap</a></li>
        </ul>
    </nav>
    <main class="container">
        <h2>Kullanıcı Arama</h2>
        <h3>Username aratarak kullanıcıları bulun.</h3>
        <form method="post" action="" class="grid">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
            <button type="submit">Ara</button>
        </form>
        <div id="results" class="result">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];

                // Prepared statement to prevent SQL injection
                $sql = "SELECT id, username, role FROM users WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<p>Kullanıcı ID: " . $row["id"] . " - Kullanıcı Adı: " . $row["username"] . " - Rolü: " . $row["role"] . "</p>";
                    }
                } else {
                    echo "<p>Bu isimde bir kullanıcı yok!</p>";
                }

                $stmt->close();
            }
            ?>
        </div>
    </main>
    <footer class="container">
        <small><a href="https://www.ozbekweb.com">Kurumsal Web Sitesi</a> • <a href="https://www.linkedin.com/in/kerim-%C3%B6zbek-74055129a/">LinkedIn</a></small>
    </footer>
</body>
</html>
