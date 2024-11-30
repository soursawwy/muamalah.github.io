<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Muamalah Repository</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Add your CSS styles here */
        .categories-list {
            list-style: none; /* Remove default bullet points */
            padding: 0; /* Remove padding */
        }

        .categories-list li {
            margin: 10px 0; /* Space between items */
        }

        .categories-list a {
            text-decoration: none; /* Remove underline */
            color: #004b8d; /* Link color */
            font-size: 1.2rem; /* Font size */
            padding: 10px; /* Add some padding */
            border-radius: 8px; /* Rounded corners */
            transition: background-color 0.3s, color 0.3s; /* Smooth transitions */
            display: inline-block; /* Make it a block to add padding */
        }

        .categories-list a:hover {
            background-color: #e0f7fa; /* Light background on hover */
            color: #004b8d; /* Darker color on hover */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Thesis Categories</h2>
        <ul class="categories-list">
            <li><a href="proposal_jurnal.php">Proposal Jurnal</a></li>
            <li><a href="jurnal.php">Jurnal</a></li>
            <li><a href="skripsi.php">Skripsi</a></li>
        </ul>
    </div>

</body>
</html>
