<?php
require_once 'includes/config_session.inc.php';
if (isset($_SESSION["errors_signup"])) {
    $errors = $_SESSION["errors_signup"];
    unset($_SESSION["errors_signup"]);
}
$form_info = [];
if (isset($_SESSION["form_info"])) {
    $form_info = $_SESSION["form_info"];
    unset($_SESSION["form_info"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Book a Book</title>
    <link rel="stylesheet" href="/library/css/style.css">

</head>
<body>
<?php include "php/header.php"; ?>
<div class="main-content">
    <div class="auth-form-container">
        <div class="auth-form">
            <h2>Create an account</h2>


            <form action="/library/includes/handle_signup.inc.php" method="POST">
                <div class="input-group">
                    <div class="input-container">
                        <input type="text" id="first_name" name="first_name" value = "<?php echo htmlspecialchars($form_info['first_name'] ?? '');?>" oninput="checkInput(this)">
                        <label for="first_name">First name</label>
                    </div>
                    <p class="error first_name <?php echo isset($errors['first_name']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['first_name']) ? $errors['first_name'] : ''; ?>
                    </p>

                    <div class="input-container">
                        <input type="text" id="last_name" name="last_name" value = "<?php echo htmlspecialchars($form_info['last_name'] ?? '');?>" oninput="checkInput(this)">
                        <label for="last_name">Last name</label>
                    </div>
                    <p class="error last_name <?php echo isset($errors['last_name']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['last_name']) ? $errors['last_name'] : ''; ?>
                    </p>

                    <div class="input-container">
                        <input type="text" id="email" name="email" value = "<?php echo htmlspecialchars($form_info['email'] ?? '');?>" oninput="checkInput(this)">
                        <label for="email">Email address</label>
                    </div>
                    <p class="error email <?php echo isset($errors['email']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['email']) ? $errors['email'] : ''; ?>
                    </p>

                    <div class="input-container">
                        <input type="text" id="phone_number" name="phone_number" value = "<?php echo htmlspecialchars($form_info['phone_number'] ?? '');?>" oninput="checkInput(this)">
                        <label for="phone_num">Phone number</label>
                    </div>
                    <p class="error phone_number <?php echo isset($errors['phone_number']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['phone_number']) ? $errors['phone_number'] : ''; ?>
                    </p>

                    <div class="input-container">
                        <input type="text" id="address" name="address" value = "<?php echo htmlspecialchars($form_info['address'] ?? '');?>" oninput="checkInput(this)">
                        <label for="address">Residential address</label>
                    </div>
                    <p class="error address <?php echo isset($errors['address']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['address']) ? $errors['address'] : ''; ?>
                    </p>

                    <div class="input-container">
                        <input type="password" id="pwd" name="pwd" value = "<?php echo htmlspecialchars($form_info['pwd'] ?? '');?>" oninput="checkInput(this)"">
                        <label for="pwd">Password</label>
                    </div>
                    <p class="error pwd <?php echo isset($errors['pwd']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['pwd']) ? $errors['pwd'] : ''; ?>
                    </p>

                    <div class="input-container">
                        <input type="password" id="pwd_confirm" name="pwd_confirm" value = "<?php echo htmlspecialchars($form_info['pwd_confirm'] ?? '');?>" oninput="checkInput(this)"">
                        <label for="pwd_confirm">Confirm password</label>
                    </div>
                    <p class="error pwd_confirm <?php echo isset($errors['pwd_confirm']) ? 'show-error' : ''; ?>">
                        <?php echo isset($errors['pwd_confirm']) ? $errors['pwd_confirm'] : ''; ?>
                    </p>
                </div>

                <button type="submit" class="btn">Sign up</button>
            </form>


            <div class="auth-switch">
                <p>Already have an account? <a href="/library/login.php">Log in</a></p>
            </div>
        </div>
    </div>
</div>


<script src="/library/js/main.js"></script>
<script src="/library/js/validate_signup.js"></script>
</body>
</html>
