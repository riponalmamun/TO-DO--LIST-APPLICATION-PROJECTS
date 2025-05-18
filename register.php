<?php
include "db.php";

session_start();

// Only process if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get POST data safely
    $firstname = $_POST['firstname'] ?? '';
    $lastname  = $_POST['lastname'] ?? '';
    $email     = $_POST['email'] ?? '';
    $password  = $_POST['password'] ?? '';

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        echo "Please fill in all required fields.";
        exit();
    }

    // Hash password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already registered
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Email already registered.";
        exit();
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to login page for user to log in after signup
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    // Prevent direct access via GET
    header("Location: register.php");
    exit();
}
?>
