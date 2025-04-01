<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost";
$db_username = "root";  
$db_password = "Abh@y2005";  
$dbname = "fmw";  

// Check if form is submitted and POST data exists
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields exist
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        echo json_encode(["success" => false, "error" => "missing_fields", "message" => "Username and password are required"]);
        exit();
    }

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to fetch username and password
        $stmt = $conn->prepare("SELECT username, pass FROM logi WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if password matches (assuming plaintext comparison)
            if ($password === $user["pass"]) {  // Note: In real scenarios, hash passwords
                $_SESSION["username"] = $username;  // Store session
                header("Location: dashboard.php");  // Redirect to dashboard
                exit();
            } else {
                echo json_encode(["success" => false, "error" => "invalid_password", "message" => "Invalid password"]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "invalid_account", "message" => "Invalid username"]);
        }

    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => "db_error", "message" => "Database error: " . $e->getMessage()]);
    }
}
?>