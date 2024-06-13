<?php
include 'config.php';
session_start();

$error = "";

// Yanlış giriş sayısını ve kilitlenme süresini kontrol edin
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}
if (!isset($_SESSION['last_attempt_time'])) {
    $_SESSION['last_attempt_time'] = 0;
}

// 5 yanlış deneme sonrası 5 dakika bekleme süresi
$waitTime = 300; // 5 dakika = 300 saniye
if ($_SESSION['attempts'] >= 5 && (time() - $_SESSION['last_attempt_time']) < $waitTime) {
    $error = "Çok fazla yanlış deneme yaptınız. Lütfen 5 dakika bekleyin.";
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // SQL enjeksiyonunu önlemek için hazırlıklı ifadeler kullanın
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Başarılı giriş durumunda giriş denemelerini sıfırlayın
                $_SESSION['attempts'] = 0;
                $_SESSION['last_attempt_time'] = 0;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id']; // user_id'yi oturum değişkeni olarak ayarlayın
                $_SESSION['role'] = $row['role'];

                // Giriş başarısını loglayın
                $logMessage = date("Y-m-d H:i:s") . " - Kullanıcı: $username, ID: " . $row['id'] . " başarıyla giriş yaptı.\n";
                file_put_contents('logs.txt', $logMessage, FILE_APPEND);

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Geçersiz şifre";
                // Geçersiz şifre denemesini loglayın
                $logMessage = date("Y-m-d H:i:s") . " - Kullanıcı: $username geçersiz şifre denemesi yaptı.\n";
                file_put_contents('logs.txt', $logMessage, FILE_APPEND);

                // Yanlış giriş sayısını artırın
                $_SESSION['attempts']++;
                $_SESSION['last_attempt_time'] = time();
            }
        } else {
            $error = "Kullanıcı bulunamadı";
            // Kullanıcı bulunamadığını loglayın
            $logMessage = date("Y-m-d H:i:s") . " - Kullanıcı: $username bulunamadı.\n";
            file_put_contents('logs.txt', $logMessage, FILE_APPEND);

            // Yanlış giriş sayısını artırın
            $_SESSION['attempts']++;
            $_SESSION['last_attempt_time'] = time();
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giriş Yap</title>
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

        main.container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
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
            gap: 10px;
            width: 100%;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
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

        .message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>Giriş Yap</h1>
        <?php
        if (!empty($error)) {
            echo "<p class='message'>$error</p>";
        }
        ?>
        <form method="post" action="">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Giriş Yap</button>
        </form>
    </main>
</body>
</html>
