<?php 
    include '_main.php';

    // delete db
    // get decrypted id
    $id = decrypt($_GET['id']);

    // query delete
    $query = mysqli_query($conn, "DELETE FROM user_details WHERE user_id=$id");

    // Redirect to index
    header("Location:index.php");
?>