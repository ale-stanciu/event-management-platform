<?php
session_start();
include_once "db_connect.php"; // Include fișierul pentru conexiunea la baza de date.

if (!isset($_SESSION['user_id'])) {
    // Dacă utilizatorul nu este autentificat, redirecționează-l la pagina de login.
    header("Location: login.html");
    exit();
}

// Verifică dacă ID-ul utilizatorului este prezent în sesiune.
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        // Pregătește și execută interogarea SQL pentru ștergerea utilizatorului.
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Verifică dacă utilizatorul a fost șters.
        if ($stmt->rowCount() > 0) {
            // Distruge sesiunea după ștergerea contului.
            session_unset();
            session_destroy();
            // Redirectează utilizatorul la pagina de login după ștergerea contului.
            header("Location: login.html");
            exit();
        } else {
            echo "Utilizatorul nu a fost găsit sau nu a fost șters.";
        }
    } catch (PDOException $e) {
        die("Eroare la baza de date: " . $e->getMessage());
    }
} else {
    // Dacă ID-ul utilizatorului nu este trimis, afișează un mesaj de eroare.
    echo "ID-ul utilizatorului necesar nu a fost furnizat.";
}
?>

