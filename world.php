<?php 
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Create a connection to the database using PDO
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Capture 'country' and 'lookup' parameters from the URL
$country = $_GET['country'] ?? ''; // Default to an empty string if not set
$lookup = $_GET['lookup'] ?? '';  // Default to an empty string if not set

// Determine which query to run based on the 'lookup' parameter
if ($lookup === 'cities') {
    // Query for cities in the specified country
    $query = "SELECT cities.name AS city, cities.district, cities.population 
              FROM cities 
              JOIN countries ON cities.country_code = countries.code 
              WHERE countries.name LIKE :country";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
} else {
    // Default query for countries
    $query = "SELECT name, continent, independence_year, head_of_state 
              FROM countries 
              WHERE name LIKE :country";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
}

// Execute the query
$stmt->execute();

// Fetch all results as an associative array
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the results in a table
if ($lookup === 'cities') {
    // Output cities in a table
    echo "<table border='1'>
        <thead>
            <tr>
                <th>City Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>";
    foreach ($results as $row) {
        echo "<tr>
            <td>" . htmlspecialchars($row['city']) . "</td>
            <td>" . htmlspecialchars($row['district']) . "</td>
            <td>" . htmlspecialchars($row['population']) . "</td>
        </tr>";
    }
    echo "</tbody></table>";
} else {
    // Output countries in a table
    echo "<table border='1'>
        <thead>
            <tr>
                <th>Country Name</th>
                <th>Continent</th>
                <th>Independence Year</th>
                <th>Head of State</th>
            </tr>
        </thead>
        <tbody>";
    foreach ($results as $row) {
        echo "<tr>
            <td>" . htmlspecialchars($row['name']) . "</td>
            <td>" . htmlspecialchars($row['continent']) . "</td>
            <td>" . htmlspecialchars($row['independence_year']) . "</td>
            <td>" . htmlspecialchars($row['head_of_state']) . "</td>
        </tr>";
    }
    echo "</tbody></table>";
}
?>
