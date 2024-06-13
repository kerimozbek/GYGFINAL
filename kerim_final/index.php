<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
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

        .links a {
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

        .links a:hover {
            background-color: #ffb400;
            transform: scale(1.05);
        }

        footer.container {
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
            <li><strong>GÜVENLİ YAZILIM GELİŞTİRME FİNAL</strong></li>
        </ul>
        <ul>
            <li><a href="#">ANA SAYFA</a></li>
            <li><a href="/kerim_final/login.php">GİRİŞ YAP</a></li>
            <li><a href="/kerim_final/register.php">KAYIT OL</a></li>
        </ul>
    </nav>

    <main class="container">
        <h1>GÜVENLİ YAZILIM GELİŞTİRME FİNAL ÖDEVİ SAYFASINA HOŞ GELDİNİZ</h1>
        <p>GİRİŞ YAPMAK İÇİN AŞAĞIDAKİ BAĞLANTILARI İZLEYEBİLİRSİNİZ.</p>
        <div class="links">
            <a href="/kerim_final/login.php">Giriş Yap</a>
            <a href="/kerim_final/register.php">Kayıt Ol</a>
        </div>
    </main>

    <footer class="container">
        <small><a href="https://www.ozbekweb.com">Kurumsal Web Sitesi</a> • <a href="https://www.linkedin.com/in/kerim-%C3%B6zbek-74055129a/">LinkedIn</a></small>
    </footer>
</body>
</html>