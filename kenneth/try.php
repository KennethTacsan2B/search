    <?php
$dsn = "mysql:host=localhost;dbname=form";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $id = $_POST["id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];

    // Update the data in the database
    $sql = "UPDATE user SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $id,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email
    ]);
    header("Location: success.php");
    exit; 
}

// Check if an 'id' is provided in the URL
if (isset($_GET["update"])) {
    $id = $_GET["update"];
    // Retrieve the data for the specified 'id'
    $sql = "SELECT * FROM user WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User with ID $id not found.";
        exit;
    }
} else {
    echo "Please provide an 'id' in the URL.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="updates.css">
    <title>Update User</title>

</head>
<body>
    <form method="POST">
        <h1>Update User Details</h1>
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>"><br>

        <label for="last_name">Last Name:</label>
        <input class="lname" type="text" name="last_name" value="<?php echo $user['last_name']; ?>"><br>

        <label for="email">Email:</label>
        <input class="email" type="text" name="email" value="<?php echo $user['email']; ?>"><br>

        <input type="submit" value="Update" class="btn">
    </form>
</body>
</html>
