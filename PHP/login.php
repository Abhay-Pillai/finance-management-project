<?php
$servername = "localhost";  
$username = "root";         
$password = "Abh@y2005";    
$dbname = "fmw";           

try {
    // Debugging: Check if PDO is enabled
    if (!extension_loaded('pdo_mysql')) {
        die("❌ PDO MySQL extension is not enabled!");
    }

    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname;charset=utf8", $username, $password);
    
    // Set PDO to throw exceptions on error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<div style='font-size: 24px; font-weight: bold; color: green; text-align: center; margin-top: 50px;'>
    ✅ Connected successfully!
    </div";
} catch (PDOException $e) {
    // Debugging: Show detailed error message
    die("❌ Connection failed: " . $e->getMessage());
}
?>
