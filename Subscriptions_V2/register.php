<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->execute([$name, $email, $hashedPassword]);
        header("Location: login.html?registered=1");
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "⚠️ Email already exists. Please use another.";
        } else {
            echo "❌ Error: " . $e->getMessage();
        }
    }
}
?>
