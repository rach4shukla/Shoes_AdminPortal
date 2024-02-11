<?php
// Include database connection file
require('dbinit.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $shoeID = $_POST['shoe_id']; 
    $name = $_POST['name'];
    $description = $_POST['description'];
    $brand = $_POST['brand']; 
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    
    $update_query = "UPDATE shoes SET shoeName=?, Description=?, Brand=?, QuantityAvailable=?, Price=? WHERE shoeID=?";
    $stmt = mysqli_prepare($dbc, $update_query);
    mysqli_stmt_bind_param($stmt, 'sssidi', $name, $description, $brand, $quantity, $price, $shoeID);
    $update_result = mysqli_stmt_execute($stmt);

    if ($update_result) {
        header("Location: index.php");
        exit(); 
    } else {
        echo "Error updating watch. Please try again.";
    }
} else {
    
    if (isset($_GET['id'])) {
        $shoeID = $_GET['id'];
        $query = "SELECT * FROM shoes WHERE shoeID=?";
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, 'i', $shoeID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shoes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h2>Edit Shoes</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="shoe_id" value="<?php echo $row['shoeID']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['shoeName']; ?>" required>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $row['Description']; ?>" required>
        <label for="brand">Brand:</label> 
        <input type="text" id="brand" name="brand" value="<?php echo $row['Brand']; ?>" required> <!-- New field for brand -->
        <label for="quantity">Quantity Available:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $row['QuantityAvailable']; ?>" required>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="any" value="<?php echo $row['Price']; ?>" required>
        <button type="submit">Update Shoe</button>
    </form>
    </div>
    
</body>
</html>
<?php
        } else {
            echo "Shoes not found.";
        }
    } else {
        // Watch ID not provided
        echo "Shoe ID is missing.";
    }
}
?>
