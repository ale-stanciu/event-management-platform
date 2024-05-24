<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Dacă utilizatorul nu este autentificat, redirecționează-l către pagina de autentificare
    echo "Nu ești autentificat.";
    header("Location: home.php");
    exit;
}

include_once "db_connect.php"; // Asigură-te că acest fișier există și are detalii corecte de conectare la baza de date

$events = []; // Inițializează un array gol pentru a stoca evenimentele

try {
    // Interogare pentru a extrage toate evenimentele pentru utilizatorul conectat
    $stmt = $pdo->prepare("SELECT * FROM events WHERE user_id = :user_id ORDER BY date DESC");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Eroare la baza de date: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Management Evenimente</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body>
    <header>
        <h1>Bine ai venit la Platforma de Management al Evenimentelor</h1>
        <nav>
            <ul>
                <li><a href="home.php">Acasă</a></li>
                <li><a href="register.html">Înregistrare</a></li>
                <li><a href="login.html">Autentificare</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="profile-dropdown">
                        <a href="#" class="dropbtn">Profil <i class="fas fa-user"></i></a>
                        <div class="profile-dropdown-content" style="display: none;">
                            <a href="delete_account.php" onclick="return confirm('Ești sigur că vrei să îți ștergi contul?');">Șterge Cont</a>
                            <a href="logout.php">Părăsește Cont</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            
        </nav>
    </header>
    <main>
        <section>
            <h2>Dashboard</h2>
            <p>Aici vei putea gestiona evenimentele tale.</p>
            <p>ID-ul utilizatorului este: <?php echo $_SESSION['user_id']; ?></p>
            <p>Email-ul utilizatorului este: <?php echo $_SESSION['user_email']; ?></p>
            
        </section>

        <section>
            <button onclick="showForm('add')">Adaugă un eveniment</button>
            <button onclick="showForm('delete')">Șterge un eveniment</button>
            <button onclick="showForm('modify')">Modifică un eveniment</button>
        </section>

        <section id="addForm" style="display:none;">
            <h2>Adaugă un nou eveniment</h2>
            <form action="add_event.php" method="post">
                <input type="text" name="event_name" placeholder="Numele evenimentului" required>
                <input type="text" name="event_date" placeholder="Data evenimentului" required>
                <input type="text" name="event_location" placeholder="Locația evenimentului" required>
                <textarea name="event_description" placeholder="Descriere"></textarea>
                <button type="submit">Adaugă eveniment</button>
            </form>
        </section>

        <section id="deleteForm" style="display:none;">
            <h2>Șterge un eveniment</h2>
            <form action="delete_event.php" method="post">
                <select name="event_id" required>
                    <option value="">Selectează un eveniment...</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?php echo htmlspecialchars($event['id']); ?>">
                            <?php echo htmlspecialchars($event['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Șterge eveniment</button>
            </form>
        </section>


        <section id="modifyForm">
            <h2>Modifică un eveniment</h2>
            <form action="dashboard.php" method="post">
                <select name="event_id_to_modify" required>
                    <option value="">Selectează un eveniment...</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?php echo htmlspecialchars($event['id']); ?>">
                            <?php echo htmlspecialchars($event['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="load_event">Încarcă Eveniment</button>
            </form>

            <?php
            if (isset($_POST['load_event'])) {
                $eventId = $_POST['event_id_to_modify'];
                $stmt = $pdo->prepare("SELECT * FROM events WHERE id = :event_id");
                $stmt->bindParam(':event_id', $eventId);
                $stmt->execute();
                $eventToModify = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($eventToModify) {
                    echo '<form action="modify_event.php" method="post">
                            <input type="hidden" name="event_id" value="' . htmlspecialchars($eventToModify['id']) . '">
                            <input type="text" name="event_name" placeholder="Numele evenimentului" required value="' . htmlspecialchars($eventToModify['name']) . '">
                            <input type="text" name="event_date" placeholder="Data evenimentului" required value="' . htmlspecialchars($eventToModify['date']) . '">
                            <input type="text" name="event_location" placeholder="Locația evenimentului" required value="' . htmlspecialchars($eventToModify['location']) . '">
                            <textarea name="event_description" placeholder="Descriere">' . htmlspecialchars($eventToModify['description']) . '</textarea>
                            <button type="submit">Modifică eveniment</button>
                        </form>';
                }
            }
            ?>
        </section>


        

    </main>
    <footer>
        <div class="footer-contact">
            <p><i class="fa fa-phone"></i> Telefon: +40768751706</p>
            <p><i class="fa fa-envelope"></i> Email: management_event_team@gmail.com</p>
        </div>
        <div class="footer-links">
            <a href="#">Termeni și condiții</a>
            <a href="#">Politica de confidențialitate</a>
        </div>
    </footer>
    <script>
    function showForm(formType) {
        document.getElementById('addForm').style.display = (formType === 'add' ? 'block' : 'none');
        document.getElementById('deleteForm').style.display = (formType === 'delete' ? 'block' : 'none');
        document.getElementById('modifyForm').style.display = (formType === 'modify' ? 'block' : 'none');
    }
    </script>

</body>
</html>
