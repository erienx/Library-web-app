<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => false, //true for https
    'httponly' => true,
]);

session_start();

if (isset($_SESSION['user_id'])) {
    if (!isset($_SESSION['last_regeneration']) || time() - $_SESSION['last_regeneration'] >= 1800) {
        regenerate_session_id();
    }
} else {
    if (!isset($_SESSION['last_regeneration']) || time() - $_SESSION['last_regeneration'] >= 1800) {
        regenerate_session_id();
    }
}

function regenerate_session_id(): void
{
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}
