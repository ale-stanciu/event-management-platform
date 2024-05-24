<?php
include_once "db_connect.php"; // Include fișierul pentru conexiunea la baza de date.

// Verifică dacă ID-ul evenimentului este trimis prin POST.
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    try {
        // Pregătește și execută interogarea SQL pentru ștergerea evenimentului.
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = :event_id");
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();

        // Redirectează utilizatorul înapoi la pagina de dashboard după ștergerea evenimentului.
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        die("Eroare la baza de date: " . $e->getMessage());
    }
} else {
    // Dacă ID-ul evenimentului nu este trimis, afișează un mesaj de eroare.
    echo "ID-ul evenimentului necesar nu a fost furnizat.";
}
?>
