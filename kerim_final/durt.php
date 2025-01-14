<?php
session_start();

// Yönetici kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Hataları göster
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$users = ['Kerim', 'Toraman', 'Mehmet']; // Sistemdeki kullanıcılar
$current_user = $_SESSION['username'];
$target_user = isset($_POST['target_user']) ? $_POST['target_user'] : '';
$message = '';
$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($target_user === 'dir') {
        // Dizin içeriğini listeleme komutu
        $command = 'cmd /c dir';
        $output = shell_exec($command);
    } elseif ($target_user === 'del logs.txt') {
        // logs.txt dosyasını silme komutu
        $command = 'cmd /c del logs.txt';
        $output = shell_exec($command);

    } elseif (in_array($target_user, $users)) {
        // Dürtme işlemi
        $command = 'cmd /c echo ' . $target_user . ' kullanicisi durtuldu.';
        $output = shell_exec($command);

        // Dürtme mesajı
        $message = $current_user . ' ' . $target_user . ' kullanicisini durttu!';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kullanıcı Dürtme</title>
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

        a, input[type="submit"] {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #ffcb05;
            color: #2b5876;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        a:hover, input[type="submit"]:hover {
            background-color: #ffb400;
            transform: scale(1.05);
        }

        select, textarea {
            width: 100%;
            border-radius: 8px;
            border: none;
            padding: 10px;
            font-size: 1em;
        }

        pre {
            background: #333;
            color: #f4f4f9;
            padding: 20px;
            border-radius: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>Kullanıcı Dürtme</h1>
        <p>Bir kullanıcıyı dürtmek için kullanıcı seçin.</p>
        <form method="POST" action="">
            <select name="target_user">
                <option value="echo DURTMEK ISTEDIGINIZ KULLANICIYI SECINIZ.">BIR KULLANICI SECINIZ</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user; ?>"><?php echo $user; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Dürt">
        </form>
        <?php if (!empty($message)): ?>
            <h2><?php echo htmlspecialchars($message); ?></h2>
        <?php endif; ?>
        <?php if (!empty($output)): ?>
            <h2>Komut Çıktısı:</h2>
            <pre><?php echo htmlspecialchars($output); ?></pre>
        <?php endif; ?>
        <a href="logout.php">Çıkış Yap</a>
    </main>
</body>
</html>
