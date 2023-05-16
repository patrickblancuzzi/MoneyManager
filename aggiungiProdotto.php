<?php
    session_start();

    $name = $_POST['name'];
    $categoria = $_POST['categoria'];
    $prezzo = $_POST['prezzo'];

    include 'dbConnection.php';

    $name = mysqli_real_escape_string($conn, $name);
    $categoria = mysqli_real_escape_string($conn, $categoria);
    $prezzo = mysqli_real_escape_string($conn, $prezzo);

    $sql = "SELECT * FROM Prodotto WHERE UserWishlist = '".$_SESSION['username']."' AND Nome = '$name'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $quantita = $row['Quantita'] + 1;
        $sql = "UPDATE Prodotto SET Quantita = '$quantita' WHERE UserWishlist = '".$_SESSION['username']."' AND Nome = '$name'";
        mysqli_query($conn, $sql);
        $sql = "UPDATE Prodotto SET Prezzo = Prezzo + '$prezzo' WHERE UserWishlist = '".$_SESSION['username']."' AND Nome = '$name'";
        mysqli_query($conn, $sql);
    }else{
        $sql = "INSERT INTO Prodotto (UserWishlist, Nome, Categoria, Prezzo, Quantita) VALUES ('".$_SESSION['username']."', '$name', '$categoria', '$prezzo', '1')";
        mysqli_query($conn, $sql);
    }

    $conn->close();

    header("Location: wishlist.php");
?>