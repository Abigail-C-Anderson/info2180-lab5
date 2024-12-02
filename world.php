<?php
// Allow cross-origin requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if 'country' parameter exists in the GET request
if (isset($_GET['country']) && !empty($_GET['country'])) {
    $country = $_GET['country'];

    // Check if the 'lookup' parameter is set to 'cities'
    if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
        // Query to fetch cities for the specified country
        $stmt = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population 
                                FROM cities 
                                JOIN countries ON cities.country_code = countries.code 
                                WHERE countries.name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output cities in a table
        echo '<table border="1">
                <thead>
                    <tr>
                        <th>City Name</th>
                        <th>District</th>
                        <th>Population</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['city_name']) . '</td>
                    <td>' . htmlspecialchars($row['district']) . '</td>
                    <td>' . htmlspecialchars($row['population']) . '</td>
                  </tr>';
        }
        echo '</tbody></table>';
    } else {
        // Query to fetch country details
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output countries in a table
        echo '<table border="1">
                <thead>
                    <tr>
                        <th>Country Name</th>
                        <th>Continent</th>
                        <th>Independence Year</th>
                        <th>Head of State</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['continent']) . '</td>
                    <td>' . htmlspecialchars($row['independence_year']) . '</td>
                    <td>' . htmlspecialchars($row['head_of_state']) . '</td>
                  </tr>';
        }
        echo '</tbody></table>';
    }
} else {
    // Default query if 'country' is not specified
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output countries in a table
    echo '<table border="1">
            <thead>
                <tr>
                    <th>Country Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>';
    foreach ($results as $row) {
        echo '<tr>
                <td>' . htmlspecialchars($row['name']) . '</td>
                <td>' . htmlspecialchars($row['continent']) . '</td>
                <td>' . htmlspecialchars($row['independence_year']) . '</td>
                <td>' . htmlspecialchars($row['head_of_state']) . '</td>
              </tr>';
    }
    echo '</tbody></table>';
}
?>