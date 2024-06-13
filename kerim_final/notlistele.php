<?php
include 'config.php';
session_start();

// Kullanıcının oturum açıp açmadığını kontrol edin
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Notları veritabanından çek
$sql = "SELECT id, username, title, note, date FROM notes";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Not Listesi</title>
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
            max-width: 1350px; /* 1.5 kat genişletildi */
            width: 90%;
            margin: 20px 0;
        }

        h1 {
            color: #ffcb05;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #2b5876;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
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
            <li><a href="notyaz.php">Not Yaz</a></li>
            <li><a href="notlistele.php">Not Listele</a></li>
            <li><a href="logout.php" role="button">Çıkış Yap</a></li>
        </ul>
    </nav>
    <main class="container">
        <h1>Not Listesi</h1>
        <table>
            <thead>
                <tr>
                    <th><strong>Notu Yazan Kişi</strong></th>
                    <th><strong>Başlık</strong></th>
                    <th><strong>Not</strong></th>
                    <th><strong>Tarih-Saat</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['note'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Kayıt bulunamadı</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Kerim Özbek. Tüm Hakları Saklıdır.</p>
    </footer>
</body>
</html>
