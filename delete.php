<!-- delete.php -->
<?php
require('dbinit.php');

if(isset($_GET['id'])) {
    $shoe_id = $_GET['id'];

    // Delete watch
    $delete_query = "DELETE FROM shoes WHERE shoeID = ?";
    $stmt = mysqli_prepare($dbc, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $shoe_id);
    $delete_result = mysqli_stmt_execute($stmt);

    if($delete_result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting shoe";
    }
}
?>
