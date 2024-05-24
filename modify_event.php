<?php
include_once "db_connect.php";

if (isset($_POST['event_id'])) {
    // Actualizarea datelor evenimentului
    $stmt = $pdo->prepare("UPDATE events SET name = :name, date = :date, location = :location, description = :description WHERE id = :id");
    $stmt->bindParam(':id', $_POST['event_id']);
    $stmt->bindParam(':name', $_POST['event_name']);
    $stmt->bindParam(':date', $_POST['event_date']);
    $stmt->bindParam(':location', $_POST['event_location']);
    $stmt->bindParam(':description', $_POST['event_description']);
    $stmt->execute();

    header("Location: dashboard.php"); // Redirecționează înapoi la dashboard
    exit;
}
?>
