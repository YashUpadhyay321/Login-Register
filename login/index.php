<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dsn = "mysql:host=localhost;dbname=login";
    $conn = new PDO($dsn, "root", "1234");

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM info WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<p style='color: red;'>Username already exists. Try another one.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO info (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            header("Location: register_success.php");
            exit;
        } else {
            echo "<p style='color: red;'>Registration failed. Please try again.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body >
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg " style="width: 380px;">
            <h3 class="text-center mb-4">Create an Account</h3>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="text-center mt-3">
                Already have an account? <a href="login.php" class="text-decoration-none">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
