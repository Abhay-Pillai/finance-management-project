<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";  
$username = "root";         
$password = "Abh@y2005";    
$dbname = "fmw";           

try {
    // Establish database connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database connected successfully!<br>";  // Debugging

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if it's a Registration Request
        if (isset($_POST['register'])) {
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                die("❌ Username or password is missing.");
            }

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                die("❌ Username and password cannot be empty.");
            }

            // Check if username already exists
            $checkUser = $conn->prepare("SELECT * FROM login WHERE username = :username");
            $checkUser->bindParam(':username', $username);
            $checkUser->execute();

            if ($checkUser->rowCount() > 0) {
                die("❌ Username already exists. Choose another.");
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user into database
            $sql = "INSERT INTO login (username, pass) VALUES (:username, :pass)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $hashedPassword, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "✅ User registered successfully!";
                header("Location: success.php");  // Redirect after success
                exit;
            } else {
                echo "❌ Registration failed!";
            }
        }

        // Check if it's a Login Request
        if (isset($_POST['login'])) {
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                die("❌ Username or password is missing.");
            }

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                die("❌ Username and password cannot be empty.");
            }

            // Fetch user from database
            $sql = "SELECT * FROM login WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['pass'])) {
                echo "✅ Login successful!";
                header("Location: dashboard.php");  // Redirect to user dashboard
                exit;
            } else {
                echo "❌ Invalid username or password!";
            }
        }
    } else {
        echo "❌ Invalid request method!";
    }
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>
