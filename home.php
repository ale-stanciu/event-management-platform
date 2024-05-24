<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Evenimente</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body>
<?php
session_start();
include_once "db_connect.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$events = [];  

if (isset($_SESSION['user_id'])) {
    $searchQuery = $search ? " AND name LIKE :search" : "";
    $orderBy = $sort === 'alphabetical' ? " ORDER BY name ASC" : " ORDER BY date DESC";
    $sql = "SELECT * FROM events WHERE user_id = :user_id" . $searchQuery . $orderBy;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    if ($search) {
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search', $searchTerm);
    }
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

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
            <h2>Evenimente tale:</h2>

            <form action="home.php" method="get">
                <input type="text" name="search" placeholder="Caută eveniment..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Caută</button>
                <button type="submit" name="sort" value="alphabetical">Sortează Alfabetic</button>
            </form>
            
            <?php if (count($events) > 0) : ?>
                <ul>
                    <?php foreach ($events as $index => $event) : ?>
                        <li class="event-item">
                            <div class="event-summary">
                                <h3><?php echo $event['name']; ?></h3>
                                <p><strong>Data:</strong> <?php echo $event['date']; ?></p>
                                <button class="view-more-btn" onclick="toggleDetails(<?php echo $index; ?>)" data-index="<?php echo $index; ?>">Vezi mai mult</button>
                            </div>
                            <div class="event-details hidden" id="details-<?php echo $index; ?>">
                                <p><strong>Locație:</strong> <?php echo $event['location']; ?></p>
                                <p><strong>Descriere:</strong> <?php echo $event['description']; ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

            <?php else : ?>
                <p>Nu ai creat încă niciun eveniment.</p>
            <?php endif; ?>
        </section>


        <section>
            <p>Apasă aici pentru a găsi mai multe evenimente:</p>
            <a href="https://www.eventim.ro/ro/">
                <img src="eventim_image.png" alt="Eventim Logo" id="logo">
            </a>
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
    <script src="js/script.js"></script>
</body>
</html>
