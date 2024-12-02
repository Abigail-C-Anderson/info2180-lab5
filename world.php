<?php
// Allow cross-origin requests
header('Access-Control-Allow-Origin: *'); // Allows requests from any origin
header('Access-Control-Allow-Methods: GET'); // Allows only GET requests
header('Access-Control-Allow-Headers: Content-Type'); // Allows Content-Type header

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if 'country' parameter exists in the GET request
if (isset($_GET['country']) && !empty($_GET['country'])) {
    $country = $_GET['country'];

    // Prepare the SQL query with a placeholder
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);
} else {
    // Default query if 'country' is not specified
    $stmt = $conn->query("SELECT * FROM countries");
}

// Fetch the results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <thead>
        <tr>
            <th>Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['continent']); ?></td>
                <td><?= htmlspecialchars($row['independence_year']); ?></td>
                <td><?= htmlspecialchars($row['head_of_state']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
