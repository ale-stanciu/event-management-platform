<?php
session_start();

// Asigură-te că utilizatorul este autentificat
if (!isset($_SESSION['user_id'])) {
    echo "Nu esti autentificat.";
    header("Location: login.html");
    exit;
}

include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // ID-ul utilizatorului autentificat
    $name = $_POST['event_name'];
    $date = $_POST['event_date'];
    $location = $_POST['event_location'];
    $description = $_POST['event_description'];

    // Crează și execută interogarea SQL pentru a adăuga un nou eveniment
    $sql = "INSERT INTO events (user_id, name, date, location, description) VALUES (:user_id, :name, :date, :location, :description)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':description', $description);

        $stmt->execute();
        echo "Eveniment adăugat cu succes!";

        header("Location: dashboard.php");
        exit;
        
    } catch (PDOException $e) {
        die("Eroare la baza de date: " . $e->getMessage());
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
