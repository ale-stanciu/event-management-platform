<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Înlocuiește cu detalii de conectare reale la PostgreSQL
$host = 'localhost';
$dbname = 'EventManagement'; // Numele bazei de date
$user = 'postgres'; // Numele de utilizator pentru baza de date
$pass = 'admin'; // Parola pentru baza de date

try {
    // Crearea conexiunii la baza de date PostgreSQL
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Procesarea datelor de login trimise prin POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Pregătirea și executarea interogării SQL
        $sql = "SELECT id, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificarea parolei
        if ($user && password_verify($password, $user['password'])) {
            // Parola este corectă, inițierea sesiunii utilizatorului
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $userRow['fullName'];

            // Redirecționarea către index.php sau dashboard-ul dorit
            header("Location: dashboard.php");
            exit();
        } else {
            // Dacă autentificarea eșuează, afișarea unui mesaj de eroare
            header("Location: login.html?error=invalid_credentials");
            exit();
        }
    }
} catch (PDOException $e) {
    // În caz de eroare la conexiunea la baza de date, afișarea unui mesaj de eroare
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}
?>
