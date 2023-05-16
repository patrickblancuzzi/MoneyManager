<?php
    session_start();

    $nomeProdotto = $_POST['nome'];

    $UserWishlist = $_SESSION['username'];

    echo $nomeProdotto;
    echo $UserWishlist;

    include 'dbConnection.php';

    $sql = "DELETE FROM Prodotto WHERE UserWishlist = '$UserWishlist' AND Nome = '$nomeProdotto'";

    echo mysqli_query($conn, $sql);
    $conn->close();

    header("Location: wishlist.php");
?>