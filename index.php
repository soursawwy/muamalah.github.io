<?php
session_start();
require 'auth.php'; 
// Disable caching to avoid redirection issues
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muamalah Repository</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Ensure the entire page takes up the full height */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        /* Main content should expand to fill available space */
        main {
            flex: 1;
        }

        /* Modal container */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Modal content box */
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 8px;
        }

        /* Close button */
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover, .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Footer styling */
        footer {
            background-color: #004b8d;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <section class="search-section">
            <div class="container">
                <h2>Cari Tesis</h2>
                <form action="search.php" method="GET" onsubmit="return validateSearch();">
                    <input type="text" name="query" id="search-bar" placeholder="Enter keywords..." />
                </form>
                <div id="search-results"></div>
            </div>
        </section>

        <section class="featured-theses">
            <div class="container">
                <h2>Sorotan</h2>
                <div class="thesis-grid">
                    <div class="thesis-card">
                        <h3>Judul Tesis 1</h3>
                        <p>Author: Diah Putri</p>
                        <p>Year: 2023</p>
                    </div>
                    <div class="thesis-card">
                        <h3>Judul Tesis 2</h3>
                        <p>Author: Diah Putri</p>
                        <p>Year: 2024</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Hukum Ekonomi Syariah UINSU</p>
        </div>
    </footer>

    <script>
        function checkLogin() {
            const isLoggedIn = <?php echo isset($_SESSION['student_id']) ? 'true' : 'false'; ?>;
            if (!isLoggedIn) {
                alert("Please login first!");
                window.location.href = "login.php";
            }
        }

        function validateSearch() {
            const searchBar = document.getElementById('search-bar').value.trim();
            if (searchBar === "") {
                alert("Please enter a search term.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
