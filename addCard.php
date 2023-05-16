<?php
    session_start();

    $titolare = $_POST["nomeTitolare"];
    $pan = $_POST["pan"];
    $dataScadenza = $_POST["dataScadenza"];
    $cvv = $_POST["cvv"];

    if(strlen($cvv) != 3){
        header("Location: index.php?error=2");
        exit();
    }

    if(strlen($pan) != 16 || is_numeric($pan) == false){
        header("Location: index.php?error=3");
        exit();
    }

    if(strlen($dataScadenza) != 7){
        header("Location: index.php?error=4");
        exit();
    }

    include "dbConnection.php";
    
    $titolare = mysqli_real_escape_string($conn, $titolare);
    $pan = mysqli_real_escape_string($conn, $pan);
    $dataScadenza = mysqli_real_escape_string($conn, $dataScadenza);
    $cvv = mysqli_real_escape_string($conn, $cvv);

    $dataScadenza = substr($dataScadenza, 2);
    $dataScadenza = str_replace("-", "/", $dataScadenza);

    $dataScadenza = substr($dataScadenza, 3, 2) . "/" . substr($dataScadenza, 0, 2);

    $sql = "SELECT * FROM Carta WHERE PAN = '$pan'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        header("Location: index.php?error=1");
        exit();
    }

    $sql = "INSERT INTO Carta (Titolare, PAN, DataScadenza, CVV, User, NomeCarta) VALUES ('$titolare', '$pan', '$dataScadenza', '$cvv', '" . $_SESSION['username'] . "', 'Carta di Credito')";

    if ($conn->query($sql) === TRUE) {
        echo "Carta aggiunta con successo";
    } else {
        header("Location: index.php?error=1");
        exit();
    }

    $conn->close();

    header("Location: index.php");
?>