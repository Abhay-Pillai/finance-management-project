

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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Sanitize and trim input data
        $fullname = trim($_POST["fullname"]);
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $dob = trim($_POST["dob"]);
        $gender = trim($_POST["gender"]);
        $address = trim($_POST["address"]);
        $country = trim($_POST["country"]);
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $confirm_password = trim($_POST["confirm_password"]);
        $bank_details = trim($_POST["bank_details"]);
        $income_sources = trim($_POST["income_sources"]);
        $credit_card = trim($_POST["credit_card"]);
        $tax_id = trim($_POST["tax_id"]);

        // Validate required fields
        if (
            empty($fullname) || empty($email) || empty($phone) || empty($dob) || 
            empty($gender) || empty($address) || empty($country) || 
            empty($username) || empty($password) || empty($confirm_password)
        ) {
            die("❌ All required fields must be filled!");
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("<div style='font-size: 24px; font-weight: bold; color: red; text-align: center; margin-top: 50px;'> 
            ❌ Invalid email format!
            </div!");
        }

        // Validate phone (10-15 digits only)
        if (!preg_match("/^[0-9]{10,15}$/", $phone)) {
            die("<div style='font-size: 24px; font-weight: bold; color: red; text-align: center; margin-top: 50px;'>
            ❌ Invalid phone number format!
            </div");
        }

        // Validate password length & match
        if (strlen($password) < 8) {
            die("❌ Password must be at least 8 characters!");
        }
        if ($password !== $confirm_password) {
            die("❌ Passwords do not match!");
        }

        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            die("<div style='font-size: 24px; font-weight: bold; color: red; text-align: center; margin-top: 50px;'>
            ❌ Username or Email already exists!
            </div");
        }

        // Hash password for security
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into database
        $sql = "INSERT INTO users (fullname, email, phone, dob, gender, address, country, username, pass, bank_details, income_sources, credit_card, tax_id) 
                VALUES (:fullname, :email, :phone, :dob, :gender, :address, :country, :username, :pass, :bank_details, :income_sources, :credit_card, :tax_id)";
              
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pass', $hashedPassword);
        $stmt->bindParam(':bank_details', $bank_details);
        $stmt->bindParam(':income_sources', $income_sources);
        $stmt->bindParam(':credit_card', $credit_card);
        $stmt->bindParam(':tax_id', $tax_id);

        $logi_sql = "INSERT INTO logi (username, pass) VALUES (:username, :pass)";
        $logi_stmt = $conn->prepare($logi_sql);
        $logi_stmt->bindParam(':username', $username);
        $logi_stmt->bindParam(':pass', $password); // Use original password here, not hashed

        // Execute the query to insert into 'logi'
        $logi_stmt->execute();

        if ($stmt->execute()) {
            echo "<div style='font-size: 24px; font-weight: bold; color: green; text-align: center; margin-top: 50px;'>
                    ✅ User registered successfully!
                  </div>";
            echo "<div style='text-align: center; margin-top: 20px;'>
                    <a href='server.html' style='font-size: 20px; color: blue; text-decoration: none; font-weight: bold;'>Go to Login</a>
                  </div>";
        }
        else {
            echo "❌ Registration failed!";
        }
    } else {
        echo "❌ Invalid request method!";
    }
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>
