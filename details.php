<?php
include '_header.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'data/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$event = getEventDetails($id);
$title = $event['title'];
?>

<main>
    <div class="container">

        <?php if ($event) : ?>
            <div class="event-details">
                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" height="400" width="800">
                <h1><?php echo htmlspecialchars($event['title']); ?></h1>
                <p class="event-description"><?php echo htmlspecialchars($event['description']); ?></p>
                <div class="event-info">
                    <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($event['event_date'])); ?></p>
                    <p><strong>Time:</strong> <?php echo date('h:ia', strtotime($event['event_date'])); ?></p>
                    <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
                </div>
                <div class="ticket-pricing">
                    <div class="tickets-grid">
                        <?php
                        $names = explode(',', $event['tier_names']);
                        $prices = explode(',', $event['tier_prices']);

                        for ($i = 0; $i < count($names); $i++) {
                            echo '<div class="ticket-card">';
                            echo '<div class="ticket-content">';
                            echo '<span class="ticket-tier">' . htmlspecialchars($names[$i]) . '</span>';
                            echo '<span class="ticket-price">$' . htmlspecialchars($prices[$i]) . '</span>';
                            echo '<button class="btn-secondary buy-ticket-btn"
                                data-event-id="' . $id . '"
                                data-tier-name="' . htmlspecialchars($names[$i]) . '"
                                data-tier-price="' . htmlspecialchars($prices[$i]) . '"
                            >Buy ' . htmlspecialchars($names[$i]) . '</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>Event not found.</p>
        <?php endif; ?>
    </div>
</main>

<div id="ticketPopup" class="popup hidden-popup">
    <div class="popup-content">
        <span class="close-btn">&times;</span>
        <h2>Buy Tickets for <span id="popupEventTitle"><?php echo htmlspecialchars($event['title']); ?></span></h2>
        <form id="ticketForm" style="margin-top: 30px;">
            <label for="userName">Name:</label>
            <input type="text" id="userName" name="userName" required>
            <label for="userEmail">Email:</label>
            <input type="email" id="userEmail" name="userEmail" required>
            <label for="ticketQuantity">Number of Tickets:</label>
            <input type="number" id="ticketQuantity" name="ticketQuantity" min="1" required>
            <div id="ticketSummary">
            </div>
            <button type="submit" class="btn-primary">Confirm Purchase</button>
        </form>
    </div>
</div>

<div id="receiptPopup" class="popup hidden-popup">
    <div class="popup-content">
        <span class="close-btn" id="closeReceiptBtn">&times;</span>
        <div id="receiptContent">
        </div>
        <button id="printReceiptBtn" class="btn-primary">Print Receipt</button>
    </div>
</div>

<script src="assets/js/purchase.js"></script>

<?php
include '_footer.php';
?>