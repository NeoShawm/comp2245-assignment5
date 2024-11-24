<?php 
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Create a connection to the database using PDO
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Capture the 'country' parameter from the URL (e.g., http://localhost/?country=USA)
$country = $_GET['country'] ?? ''; // Use the GET parameter, or an empty string if not set

// Modify the query to include the search filter if 'country' is provided
if ($country) {
    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM countries WHERE name LIKE :country";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR); // Bind the country value
} else {
    // Default query if no 'country' parameter is passed
    $query = "SELECT * FROM countries";
    $stmt = $conn->query($query);
}

// Execute the query
$stmt->execute();

// Fetch all results as an associative array
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
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['continent']) ?></td>
                <td><?= htmlspecialchars($row['independence_year']) ?></td>
                <td><?= htmlspecialchars($row['head_of_state']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
