<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "id22218414_phpuser";
$password = "zE792a|*";
$dbname = "id22218414_planpal";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

function insertEvent($user_id, $title, $description, $venue, $image, $event_date) {
    global $conn;
    $sql = "INSERT INTO events (user_id, title, description, venue, image, event_date) VALUES (:user_id, :title, :description, :venue, :image, :event_date)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':venue', $venue);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':event_date', $event_date);
    $stmt->execute();
    return $conn->lastInsertId();
}

function insertEventPriceTier($event_id, $tier_name, $price, $available_tickets) {
    global $conn;
    $sql = "INSERT INTO event_price_tiers (event_id, tier_name, price, available_tickets, initial_available_tickets) VALUES (:event_id, :tier_name, :price, :available_tickets, :initial_available_tickets)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':event_id', $event_id);
    $stmt->bindParam(':tier_name', $tier_name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':available_tickets', $available_tickets);
    $stmt->bindParam(':initial_available_tickets', $available_tickets);
    $stmt->execute();
}

function insertUser($email, $first_name, $last_name, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (email, first_name, last_name, password) VALUES (:email, :first_name, :last_name, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();
    return $conn->lastInsertId();
}

function verifyUser($email, $password) {
    global $conn;
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        return $user['id'];
    }
    return false;
}

function getRandomEventsWithPrices($limit) {
    global $conn;
    $sql = "
        SELECT e.*, 
               GROUP_CONCAT(pt.tier_name ORDER BY pt.id) as tier_names, 
               GROUP_CONCAT(pt.price ORDER BY pt.id) as tier_prices, 
               GROUP_CONCAT(pt.available_tickets ORDER BY pt.id) as tier_tickets 
        FROM events e
        LEFT JOIN event_price_tiers pt ON e.id = pt.event_id
        GROUP BY e.id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    shuffle($events);
    return array_slice($events, 0, $limit);
}

function formatPriceTiers($tier_names, $tier_prices) {
    $names = explode(',', $tier_names);
    $prices = explode(',', $tier_prices);
    $formatted = [];
    foreach ($names as $index => $name) {
        $formatted[] = '<div class="chip">' . $name . ": $" . $prices[$index] . '</div>';
    }
    return implode('', $formatted);
}

function getFilteredEvents($search) {
    global $conn;
    $sql = "SELECT * FROM events WHERE title LIKE :search OR description LIKE :search ORDER BY event_date ASC";
    $stmt = $conn->prepare($sql);
    $searchParam = '%' . $search . '%';
    $stmt->bindParam(':search', $searchParam);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEventDetails($id)
{
    global $conn;
    $sql = "
        SELECT e.*, 
               GROUP_CONCAT(pt.tier_name ORDER BY pt.id) as tier_names, 
               GROUP_CONCAT(pt.price ORDER BY pt.id) as tier_prices, 
               GROUP_CONCAT(pt.available_tickets ORDER BY pt.id) as tier_tickets 
        FROM events e
        LEFT JOIN event_price_tiers pt ON e.id = pt.event_id
        WHERE e.id = :id
        GROUP BY e.id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
