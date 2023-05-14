<?php
    $usernameForm = $_GET["un"];

    include "../dbConnection.php";

    $sql = "SELECT * FROM Utente WHERE Username = '$usernameForm'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        $sql = "DELETE FROM Utente WHERE Username = '$usernameForm' AND FlagVerifica = 1";
        $result = $conn->query($sql);

        $conn->close();
        header("Location: ../Login.php");
        exit();
    }
?>