<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Not Akışı</title>
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
            color: #ffcb05;
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
            max-width: 800px;
            width: 90%;
            margin: 20px 0;
            color: #fff;
        }

        .post {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #fff;
        }

        .post h2 {
            margin: 0 0 10px;
            font-size: 1.5em;
            color: #ffcb05;
        }

        .post p {
            margin: 0 0 10px;
            color: #fff;
        }

        .post .date {
            color: #ddd;
            font-size: 0.9em;
        }

        .like-btn, .dislike-btn {
            background: #ffcb05;
            color: #2b5876;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .like-btn:hover, .dislike-btn:hover {
            background-color: #ffb400;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .likes-count, .dislikes-count {
            color: #ddd;
            font-size: 0.9em;
            display: inline-block;
            margin-left: 10px;
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
            <li><strong>Not Akışı</strong></li>
        </ul>
        <ul>
            <li><a href="dashboard.php">Yönetim Paneli</a></li>
            <li><a href="durt.php" role="button">Kullanıcı Dürt</a></li>
            <li><a href="notyaz.php">Not Yaz</a></li>
            <li><a href="logout.php">Çıkış Yap</a></li>
        </ul>
    </nav>
    <main class="container">
        <h1>Not Akışı</h1>
        <div id="posts"></div>
    </main>
    <footer>
        <p>&copy; 2024 Kerim Özbek. Tüm Hakları Saklıdır.</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('fetch_notes.php')
            .then(response => response.json())
            .then(data => {
                const postsContainer = document.getElementById('posts');
                data.forEach(note => {
                    const post = document.createElement('div');
                    post.classList.add('post');
                    post.innerHTML = `
                        <h2>${note.title}</h2>
                        <p>${note.note}</p>
                        <p class="date">Yazan: ${note.username} - ${note.date}</p>
                        <p class="likes-count">Likes: <span id="likes-${note.id}">${note.likes}</span></p>
                        <p class="dislikes-count">Dislikes: <span id="dislikes-${note.id}">${note.dislikes}</span></p>
                        <button class="like-btn" data-id="${note.id}">Like</button>
                        <button class="dislike-btn" data-id="${note.id}">Dislike</button>
                    `;
                    postsContainer.appendChild(post);
                });

                document.querySelectorAll('.like-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const noteId = this.getAttribute('data-id');
                        fetch('like_dislike_note.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'note_id=' + noteId + '&action=like'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const likesCount = document.getElementById('likes-' + noteId);
                                const dislikesCount = document.getElementById('dislikes-' + noteId);
                                likesCount.textContent = data.likes;
                                dislikesCount.textContent = data.dislikes;
                            } else {
                                console.error('Error:', data.message);
                            }
                        })
                        .catch(error => console.error('Fetch error:', error));
                    });
                });

                document.querySelectorAll('.dislike-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const noteId = this.getAttribute('data-id');
                        fetch('like_dislike_note.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'note_id=' + noteId + '&action=dislike'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const likesCount = document.getElementById('likes-' + noteId);
                                const dislikesCount = document.getElementById('dislikes-' + noteId);
                                likesCount.textContent = data.likes;
                                dislikesCount.textContent = data.dislikes;
                            } else {
                                console.error('Error:', data.message);
                            }
                        })
                        .catch(error => console.error('Fetch error:', error));
                    });
                });
            })
            .catch(error => console.error('Fetch error:', error));
    });
    </script>
</body>
</html>
