<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
        function validateLogin() {
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();

            let emailError = document.getElementById("emailError");
            let passwordError = document.getElementById("passwordError");

            emailError.innerText = "";
            passwordError.innerText = "";

            let isValid = true;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === "") {
                emailError.innerText = "* Email is required!";
                isValid = false;
            }else if (!emailPattern.test(email)) {
                emailError.innerText = "* Enter a valid email address!";
                isValid = false;
            }

            if (password === "") {
                passwordError.innerText = "* Password is required!";
                isValid = false;
            }

            return isValid;

        }
    </script>
</head>
<body>
    <div id="form_container">
        <h1>Sign In</h1>
        <form action="../controller/loginController.php" method="post" onsubmit="return validateLogin()">

            <div class="form-group">
                <input type="text" name="email" id="email">
                <label for="email">Email</label>
                <span id="emailError" class="error"></span>
            </div>

            <div class="form-group">
                <input type="password" name="password" id="password">
                <label for="password">Password</label>
                <span id="passwordError" class="error"></span>
            </div>

            <?php if (isset($_SESSION["login_error"])): ?>
                <div class="form-group">
                    <span class="error"><?php echo $_SESSION["login_error"]; unset($_SESSION["login_error"]); ?></span>
                </div>
            <?php endif; ?>

            <button type="submit">Login</button>

            <div class="bottom-links">
                <p><a href="forgot_password.php">Forgot Password?</a></p>
                <p>Don't have an account? <a href="registration.php">Sign Up</a></p>
            </div>
        </form>
    </div>
</body>
</html>
