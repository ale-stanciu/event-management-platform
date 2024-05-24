<?php
// Inițiază sesiunea pentru a putea accesa și distruge variabilele sesiunii
session_start();

// Distruge toate datele sesiunii
$_SESSION = array();

// Distrugerea sesiunii
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// În cele din urmă, distruge sesiunea și redirecționează utilizatorul către pagina principală
session_destroy();

// Redirecționarea către index.html sau la pagina de login, după preferință
header("Location: login.html");
exit;
?>
