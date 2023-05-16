<?php
    $pan = $_GET["pan"];

    include "dbConnection.php";

    $sql = "DELETE FROM Carta WHERE PAN = '$pan'";

    if ($conn->query($sql) === TRUE) {
        echo "Carta eliminata con successo";
    } else {
        echo "Errore nella cancellazione della carta: " . $conn->error;
    }

    $conn->close();

    header("Location: index.php");
?>