<?php
require_once 'includes/config_session.inc.php';
if (isset($_SESSION["errors_login"])) {
    $errors = $_SESSION["errors_login"];
    unset($_SESSION["errors_login"]);
}
$form_info = [];
if (isset($_SESSION["form_info"])) {
    $form_info = $_SESSION["form_info"];
    unset($_SESSION["form_info"]);
}
$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Book a Book</title>
    <link rel="stylesheet" href="/library/css/style.css">
</head>
<body>
<?php include "php/header.php"; ?>
<div class="main-content">
    <div class="auth-form-container">
        <div class="auth-form">
            <h2>Welcome back</h2>
            <form action="/library/includes/handle_login.inc.php" method="POST">
                <div class="input-group">
                    <div class="input-container">
                        <input type="text" id="email" name="email" value = "<?php echo htmlspecialchars($form_info['email'] ?? '');?>" oninput="checkInput(this)">
                        <label for="email" >Email address</label>
                    </div>
                    <p class="error email <?php echo isset($errors['email']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['email']) ? $errors['email'] : ''; ?>
                    </p>

                    <div class="input-container">
                        <input type="password" id="pwd" name="pwd"  oninput="checkInput(this)">
                        <label for="pwd">Password</label>
                    </div>
                    <p class="error pwd <?php echo isset($errors['pwd']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['pwd']) ? $errors['pwd'] : ''; ?>
                    </p>
                </div>

                <button type="submit" class="btn">Log in</button>
            </form>

            <div class="auth-switch">
                <p>Don't have an account? <a href="/library/register.php">Sign Up</a></p>
            </div>
        </div>
        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="/library/js/main.js"></script>
<script src="/library/js/validate_login.js"></script>
<script src = /library/js/success_message_fade.js></script>
</body>
</html>
