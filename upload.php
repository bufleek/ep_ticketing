<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'data/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $event_date = $date . ' ' . $time;

    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        // create image name from timestamp and file extension
        $imageName = time() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        //$imageName = basename($_FILES['image']['name']);
        $uploadFileDir = './uploads/';

        $dest_path = $uploadFileDir . $imageName;

        if(move_uploaded_file($imageTmpPath, $dest_path)) {
            $image = $dest_path;
        } else {
            echo "There was an error moving the uploaded file.";
            exit;
        }
    }

    // Insert event
    $event_id = insertEvent($user_id, $title, $description, $venue, $image, $event_date);

    // Insert price tiers
    for ($i = 1; $i <= 3; $i++) {
        if (!empty($_POST["tier$i"]) && !empty($_POST["price$i"]) && !empty($_POST["quantity$i"])) {
            $tier_name = $_POST["tier$i"];
            $tier_price = $_POST["price$i"];
            $available_tickets = $_POST["quantity$i"];
            insertEventPriceTier($event_id, $tier_name, $tier_price, $available_tickets);
        }
    }

    echo '<div class="success_indicator"><div class="container">Uploaded successfully.</div></div>';
}
?>

<?php
$title = "Upload Event";
include '_header.php';
?>
<main>
    <div class="container">
        <div class="form upload-form center">
            <h2>Upload Event</h2>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-section">
                    <h3>Event Info</h3>
                    <div class="form-group">
                        <label for="title">Event Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue</label>
                        <input type="text" id="venue" name="venue" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Event Image</label>
                        <input type="file" id="image" name="image" required accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" id="time" name="time" required>
                    </div>
                </div>

                <div class="form-section price-tiers-section">
                    <h3>Tickets and Pricing</h3>
                    <div class="form-group">
                        <label for="tier1">Price Tier 1</label>
                        <input type="text" id="tier1" name="tier1" placeholder="Tier Name (e.g. VIP)" required>
                        <input type="number" id="price1" name="price1" placeholder="Price" required>
                        <input type="number" id="quantity1" name="quantity1" placeholder="Available Tickets" required>
                    </div>
                    <div class="form-group">
                        <label for="tier2">Price Tier 2</label>
                        <input type="text" id="tier2" name="tier2" placeholder="Tier Name (e.g. Regular)">
                        <input type="number" id="price2" name="price2" placeholder="Price">
                        <input type="number" id="quantity2" name="quantity2" placeholder="Available Tickets">
                    </div>
                    <div class="form-group">
                        <label for="tier3">Price Tier 3</label>
                        <input type="text" id="tier3" name="tier3" placeholder="Tier Name (e.g. VVIP)">
                        <input type="number" id="price3" name="price3" placeholder="Price">
                        <input type="number" id="quantity3" name="quantity3" placeholder="Available Tickets">
                    </div>
                </div>

                <button type="submit" class="btn-primary">Upload Event</button>
            </form>
        </div>
    </div>
</main>
<?php
include '_footer.php';
?>
