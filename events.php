<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include 'data/db.php';

$title = "Events";
include '_header.php';


$search = isset($_GET['search']) ? $_GET['search'] : '';
$events = getFilteredEvents($search);
?>

<main class="h-100">
    <div class="container">
        <h1 class="py-20">All Events</h1>
        <section class="search-bar">
            <div class="container">
                <form action="events.php" method="GET">
                    <input type="text" name="search" placeholder="Search for events" />
                    <button type="submit" class="btn-secondary">Search</button>
                </form>
            </div>
        </section>
        <br />
        <div class="events-list">
            <?php foreach ($events as $event) : ?>
                <div class="event-item hidden">
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                    <div class="event-info">
                        <h2><?php echo htmlspecialchars($event['title']); ?></h2>
                        <p><?php echo date('d M Y (h:ia)', strtotime($event['event_date'])); ?> | <?php echo htmlspecialchars($event['venue']); ?></p>
                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                        </br>
                        <a href="details.php?id=<?php echo $event['id']; ?>" class="btn-secondary">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
include '_footer.php';
?>