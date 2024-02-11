<!-- index.php -->
<?php
require('dbinit.php');

// Process form submission
if (isset($_POST["add_shoe"])) {
    // Retrieve and sanitize form data
    $name = prepare_string($dbc, $_POST['name']);
    $description = prepare_string($dbc, $_POST['description']);
    $brand = prepare_string($dbc, $_POST['brand']); 
    $quantity = prepare_string($dbc, $_POST['quantity']);
    $price = prepare_string($dbc, $_POST['price']);

    // Insert data into watches table
    $insert_query = "INSERT INTO shoes (shoeName, Description, Brand, QuantityAvailable, Price) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbc, $insert_query);
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $description, $brand, $quantity, $price);
    $insert_result = mysqli_stmt_execute($stmt);


    if ($insert_result) {
        echo "<p class='success'>New shoe added successfully!</p>";
        header("Location: index.php");
        exit();
    } else {
        echo "<p class='error'>Error adding shoe. Please try again.</p>";
    }
}

function prepare_string($dbc, $string) {
    $string_trimmed = trim($string);
    $string = mysqli_real_escape_string($dbc, $string_trimmed);
    return $string;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Portal</h1>
        <!-- Display Existing shoes -->
        <h2>Existing Shoes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Quantity Available</th>
                    <th>Price</th>
                    <th>Product added by</th>
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                    $query = "SELECT * FROM shoes";
                    $result = mysqli_query($dbc, $query);

                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['shoeID'] . "</td>";
                        echo "<td>" . $row['shoeName'] . "</td>";
                        echo "<td>" . $row['Description'] . "</td>";
                        echo "<td>" . $row['Brand'] . "</td>";
                        echo "<td>" . $row['QuantityAvailable'] . "</td>";
                        echo "<td>" . $row['Price'] . "</td>";
                        echo "<td>" . $row['ProductAddedBy'] . "</td>";
                        echo "<td><a href='edit.php?id=" . $row['shoeID'] . "'>Edit</a> | <a href='delete.php?id=" . $row['shoeID'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <h2>Add New Shoes</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required>
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required>
            <label for="quantity">Quantity Available:</label>
            <input type="number" id="quantity" name="quantity" required>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="any" required>
            <button type="submit" name="add_shoe">Add Shoes</button>
        </form>
    </div>
</body>
</html>
