<?php
include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash pentru parolă

    // Validează email-ul (poți adăuga mai multe verificări aici)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresa de email introdusă nu este validă.";
        exit();
    }

    // Verifică dacă adresa de email este deja înregistrată
    $query = "SELECT COUNT(*) AS num FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['num'] > 0) {
        echo "Adresa de email este deja înregistrată.";
        exit();
    }

    // Inserează datele în baza de date
    $query = 'INSERT INTO users ("fullName", "email", "password") VALUES (:fullName, :email, :password)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    if ($stmt->execute()) {
       echo "Înregistrarea a fost realizată cu succes!";
       header("Location: login.html");
            exit();
    } else {
       echo "Eroare la înregistrare. Vă rugăm să încercați din nou.";
    }

}
?>