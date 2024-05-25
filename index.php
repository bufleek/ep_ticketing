<?php
$title = "Home";
include '_header.php';
include 'data/db.php';

$eventsForYou = getRandomEventsWithPrices(5);
$specialDeals = getRandomEventsWithPrices(5);
?>

<main>
  <section class="banner">
    <div class="container">
      <h1>Welcome to PlanPal</h1>
      <p>Your go-to platform for amazing events</p>
      <section class="search-bar center">
        <div class="container">
          <form action="events.php" method="GET">
            <input type="text" name="search" placeholder="Search for events" />
            <button type="submit" class="btn-secondary">Search</button>
          </form>
        </div>
      </section>
    </div>
  </section>

  <section class="events">
    <div>
      <h2>Event for you</h2>
      <div class="events-scroll">
        <?php foreach ($eventsForYou as $event) : ?>
          <div class="event-card">
            <a href="details.php?id=<?php echo $event['id']; ?>">
              <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
              <h3><?php echo htmlspecialchars($event['title']); ?></h3>
              <p><?php echo date('d M Y (h:ia)', strtotime($event['event_date'])); ?> | <?php echo htmlspecialchars($event['venue']); ?></p>
              <div class="price-tiers">
                <?php echo formatPriceTiers($event['tier_names'], $event['tier_prices']); ?>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <section class="events">
    <div>
      <h2>Special Deals</h2>
      <div class="events-scroll">
        <?php foreach ($specialDeals as $event) : ?>
          <div class="event-card">
            <a href="details.php?id=<?php echo $event['id']; ?>">
              <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
              <h3><?php echo htmlspecialchars($event['title']); ?></h3>
              <p><?php echo date('d M Y (h:ia)', strtotime($event['event_date'])); ?> | <?php echo htmlspecialchars($event['venue']); ?></p>
              <div class="price-tiers">
                <?php echo formatPriceTiers($event['tier_names'], $event['tier_prices']); ?>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>

<?php include '_footer.php'; ?>