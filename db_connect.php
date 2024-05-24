<?php
$host = 'localhost'; // sau adresa IP pentru serverul PostgreSQL
$dbname = 'EventManagement';
$user = 'postgres'; // înlocuiește cu numele tău de utilizator pentru baza de date
$password = 'admin'; // înlocuiește cu parola ta

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // setează modul de eroare PDO la excepție
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectat cu succes la baza de date PostgreSQL";
} catch (PDOException $e) {
    echo "Eroare la conectare: " . $e->getMessage();
}
?>
