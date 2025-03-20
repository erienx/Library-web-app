<?php 
require_once 'dbh.inc.php';
function get_email(object $pdo,string $email){
    try{
        $query = "select * from members where email = :email;";

        $statement = $pdo->prepare($query);
        $statement->bindParam(":email", $email);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $statement = null;

        return $result ?: null;
    }catch(PDOException $exception){
        die("Query failed: " . $exception->getMessage());
    }
}
function get_user(object $pdo,string $email){
    $sql = "SELECT * FROM members WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    return $user_data;
}
function get_user_id(object $pdo,string $email){
    $sql = "SELECT members.member_id FROM members WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    return $user_data['member_id'] ?? NULL;
}
function is_pwd_correct(string $pwd,string $hashed_pwd): bool
{
    return password_verify($pwd, $hashed_pwd);
}
function is_email_taken(object $pdo,$email): bool{
    if (get_email($pdo,$email)){
        return true;
    }
    return false;
}

function is_phone_number_valid($phoneNumber): bool{
    return preg_match("/^[0-9 ]+$/",$phoneNumber) === 1;
}
function is_name_valid($name): bool{
    return preg_match('/^[\p{L}]+$/u', $name);
}
function is_text_empty($name): bool{
    return empty($name);
}
function is_email_valid($email): bool{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function is_address_valid($address): bool{
    return !empty($address);
}
function are_pwd_matching($pwd, $pwd_confirm): bool{
    return $pwd_confirm === $pwd;
}
function is_pwd_valid($pwd): bool{
    return !empty($pwd) && strlen($pwd) >= 6;
}