<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
require_once("../db.php");
require '../vendor/autoload.php'; 
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
 
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["reset_error"] = "Please enter a valid email.";
        header("Location: ../view/forgot_password.php");
        exit;
    }
 
    $conn = getConnection();
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
 
    if (mysqli_num_rows($result) === 0) {
        $_SESSION["reset_error"] = "Email not found.";
        header("Location: ../view/forgot_password.php");
        exit;
    }
 
    
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+15 minutes"));
 
    
    $sql = "INSERT INTO password_resets (email, token, expires_at)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE token=?, expires_at=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $email, $token, $expires, $token, $expires);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn); 
    
    $resetLink = "http://localhost/Web_Tech_Project/view/reset_password.php?token=$token";
 
    $mail = new PHPMailer(true);
    try {
        
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Gmail SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'skbadhon600@gmail.com'; // your Gmail
        $mail->Password   = 'jfpxohwegubtsyab'; // your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
 
        
        $mail->setFrom('skbadhon600@gmail.com', 'Library Management System');
        $mail->addAddress($email);
 
        
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a>";
 
        $mail->send();
        $_SESSION["reset_message"] = "Password reset link has been sent to your email.";
    } catch (Exception $e) {
        $_SESSION["reset_error"] = "Could not send email. Mailer Error: {$mail->ErrorInfo}";
    }
 
    header("Location: ../view/forgot_password.php");
    exit;
}
?>


 
 
 