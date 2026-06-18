<?php
header('Content-Type: application/json');

// Database config
$host = "localhost";
$username = "root";
$password = "";
$database = "metric_conversions_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email address"]);
        exit;
    }

    // Insert safely
    $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Thank you for subscribing!"]);
    } else {
        if ($conn->errno == 1062) {
            echo json_encode(["status" => "error", "message" => "This email is already subscribed"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Something went wrong"]);
        }
    }

    $stmt->close();
}

$conn->close();
?>
