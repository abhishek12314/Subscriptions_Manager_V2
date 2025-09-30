<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = trim($_POST['mobile']);
    $stmt = $pdo->prepare("SELECT id FROM users WHERE mobile = :mobile");
    $stmt->execute(['mobile' => $mobile]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['otp_error'] = "Mobile number not found.";
        header("Location: forgot_password.php");
        exit;
    }
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_mobile'] = $mobile;
    $_SESSION['otp_time'] = time();
    $_SESSION['otp_sent'] = true;
    header("Location: forgot_password.php");
    exit;
}
