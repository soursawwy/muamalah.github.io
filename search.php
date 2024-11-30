<?php
session_start();
require 'auth.php'; 
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'muamalah_repository');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search query
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';
$theses = [];

if ($searchQuery) {
    $stmt = $conn->prepare("SELECT id, title, author, year, filePath FROM theses 
                             WHERE id LIKE ? OR title LIKE ? OR author LIKE ? OR year LIKE ? OR filePath LIKE ?");
    $likeQuery = '%' . $searchQuery . '%';
    $stmt->bind_param('sssss', $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $theses[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Muamalah Repository</title>
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
        /* Modern styles for the search page */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .search-form {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .search-form input {
            width: 70%;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }
        .search-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            background-color: #1d72b8;
            color: white;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #155a8a;
        }
        .search-results {
            margin-top: 20px;
        }
        .thesis-card {
            background: #f9f9f9;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .thesis-card h3 {
            margin-top: 0;
        }
        .thesis-card p {
            margin: 5px 0;
            color: #555;
        }
        .thesis-card a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #1d72b8;
            font-weight: 500;
        }
        .thesis-card a:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            margin-top: 30px;
            padding: 10px 0;
            background: #1d72b8;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Search Theses</h2>
        <form action="search.php" method="GET" class="search-form">
            <input 
                type="text" 
                name="query" 
                placeholder="Enter keywords..." 
                value="<?= htmlspecialchars($searchQuery) ?>" 
                required 
            />
            <button type="submit">Search</button>
        </form>

        <div class="search-results">
            <?php if ($searchQuery && empty($theses)): ?>
                <p>No results found for "<?= htmlspecialchars($searchQuery) ?>"</p>
            <?php elseif ($theses): ?>
                <?php foreach ($theses as $thesis): ?>
                    <div class="thesis-card">
                        <h3><?= htmlspecialchars($thesis['title']) ?></h3>
                        <p>ID: <?= htmlspecialchars($thesis['id']) ?></p>
                        <p>Author: <?= htmlspecialchars($thesis['author']) ?></p>
                        <p>Year: <?= htmlspecialchars($thesis['year']) ?></p>
                        <a href="pdf_viewer.php?file=<?= urlencode($thesis['filePath']) ?>" target="_blank">View PDF</a>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Muamalah Repository</p>
    </footer>
</body>
</html>
