<?php
session_start();  // Start a session
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


header("Content-Type: application/json");

// Database connection details
$servername = "localhost";
$db_username = "root";  // Change this if using another MySQL user
$db_password = "Abh@y2005";  // Set your MySQL root password
$dbname = "fmw";  // Your database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["username"]) || !isset($data["password"])) {
        echo json_encode(["success" => false, "error" => "missing_fields", "message" => "Username and password are required"]);
        exit;
    }

    $username = trim($data["username"]); // Fetch the username field from input
    $password = trim($data["password"]); // Fetch the password field

    // Fetch only username and hashed password from database
    $stmt = $conn->prepare("SELECT username, pass FROM logi WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check if entered password matches stored password
        if ($password === $user["pass"]) {  // No password hashing (direct match)
            echo json_encode(["success" => true, "redirect" => "mainpage3.html", "message" => "Login successful"]);
        } else {
            echo json_encode(["success" => false, "error" => "invalid_password", "message" => "Invalid password"]);
        }
    } else {
        // If username is not found, redirect to no_account.html
        echo json_encode(["success" => false, "redirect" => "no_account.html", "message" => "Invalid Account"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "db_error", "message" => "Database error: " . $e->getMessage()]);
}
?>