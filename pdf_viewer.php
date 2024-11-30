<?php
session_start();
require 'auth.php'; 

// Disable cache
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Get the file from the query string
$file = isset($_GET['file']) ? $_GET['file'] : '';

if (empty($file)) {
    die('File not specified.');
}

// Specify the full path to the PDFs directory
$pdfPath = __DIR__ . '/assets/pdfs/' . basename($file); // use basename to prevent directory traversal

// Check if the file exists
if (!file_exists($pdfPath)) {
    die('File not found: ' . htmlspecialchars($pdfPath));
}

// Set the appropriate headers to view the PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($pdfPath) . '"');
readfile($pdfPath);
exit();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
</head>
<body>
    <h1>PDF Viewer</h1>
    <iframe src="<?= htmlspecialchars($fullPath) ?>" style="width:100%; height:100vh;" frameborder="0"></iframe>
</body>
</html>
