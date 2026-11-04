<?php

session_start();

// Set default language
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// Change language
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}

// Fetch content in the selected language
$query = "SELECT text_$lang AS text FROM Content WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $contentId);
$stmt->execute();
$result = $stmt->get_result();
$content = $result->fetch_assoc();
echo $content['text'];

?>