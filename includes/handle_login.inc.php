<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];


    try {
        require_once 'dbh.inc.php';
        require_once 'validations.inc.php';
        $errors = [];

        $user = null;
        if (is_text_empty($email)) {
            $errors["email"] = "Email is empty";
        }
        else {
            $user = get_user($pdo, $email);
            if (!$user) {
                $errors["pwd"] = "Email or password is incorrect";
            }
        }
        if (is_text_empty($pwd)) {
            $errors["pwd"] = "Password is empty";
        } else if (!$user || !is_pwd_correct($pwd, $user["pwd"])) {
            $errors["pwd"] = "Email or password is incorrect";
        }

        require_once 'config_session.inc.php';
        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            $_SESSION["form_info"] = $_POST;
            $pdo = null;
            header("Location: /library/login.php");
            die();
        }



        $_SESSION['user_id'] = $user["member_id"];
        $_SESSION['user_email'] = htmlspecialchars($user["email"]);
        $_SESSION['is_admin'] = $user["is_admin"];

        if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
            require_once 'cart.inc.php';
            foreach ($_SESSION["cart"] as $book_id) {
                if (!is_book_in_cart($_SESSION['user_id'],$book_id, $pdo)) {
                    add_to_cart($_SESSION['user_id'], $book_id, $pdo);
                }
            }
        }

        $pdo = null;
        header("Location: /library");
        die();

    }catch(PDOException $exception){
        die("Query failed: " . $exception->getMessage());
    }
}

else{
    header("Location: /library");
    die();
}
