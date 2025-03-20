<?php
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];
    $pwd = $_POST["pwd"];
    $pwd_confirm = $_POST["pwd_confirm"];

    require_once "validations.inc.php";
    try{


        $errors = [];
        if (is_text_empty($first_name)){
            $errors["first_name"] = "First name is empty";
        }
        else if (!is_name_valid($first_name)){
            $errors["first_name"] = "First name is invalid";
        }

        if (is_text_empty($last_name)){
            $errors["last_name"] = "Last name is empty";
        }
        else if (!is_name_valid($last_name)){
            $errors["last_name"] = "Last name is invalid";
        }

        if (is_text_empty($email)){
            $errors["email"] = "Email is empty";
        }
        else if (!is_email_valid($email)){
            $errors["email"] = "Email is invalid";
        }
        else if (is_email_taken($pdo, $email)){
            $errors["email"] = "Email is already taken";
        }

        if (is_text_empty($phone_number)){
            $errors["phone_number"] = "Phone number is empty";
        }
        else if (!is_phone_number_valid($phone_number)){
            $errors["phone_number"] = "Phone number is invalid";
        }

        if (is_text_empty($address)){
            $errors["address"] = "Address is empty";
        }

        if (is_text_empty($pwd)){
            $errors["pwd"] = "Password is empty";
        }
        else if (!is_pwd_valid($pwd)){
            $errors["pwd"] = "Password must be at least 6 characters long";
        }

        if (is_text_empty($pwd_confirm)){
            $errors["pwd_confirm"] = "Confirm password is empty";
        }
        else if (!are_pwd_matching($pwd, $pwd_confirm)){
            $errors["pwd_confirm"] = "Passwords do not match";
        }



        require_once 'config_session.inc.php';
        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            $_SESSION["form_info"] = $_POST;
            $pdo = null;
            header("Location: /library/php/register.php");
            die();
        }

        else{
            $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);

            $query = "INSERT INTO members (first_name, last_name, email, phone_number, address, pwd)  VALUES (:first_name, :last_name, :email, :phone_number, :address, :pwd)";

            $statement = $pdo->prepare($query);

            $statement->bindParam(":first_name", $first_name);
            $statement->bindParam(":last_name", $last_name);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":phone_number", $phone_number);
            $statement->bindParam(":address", $address);
            $statement->bindParam(":pwd", $pwd_hash);

            $statement->execute();

            $pdo = null;
            $statement = null;
            $_SESSION['success_message'] = "Your account has been created! You may now log in.";
            header("Location: /library/login.php");
            die();
        }
    }catch(PDOException $exception){
        die("Query failed: " . $exception->getMessage());
    }
}
else{
    header("Location: /library");
    die();
}


