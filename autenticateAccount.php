<?php
    $code = $_GET["code"];
    $usernameVerify = $_GET["username"];

    include "../dbConnection.php";

    $sql = "SELECT * FROM Utente WHERE Username = '$usernameVerify' AND CodiceVerifica = '$code'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $sql = "UPDATE Utente SET FlagVerifica = 0 WHERE Username = '$usernameVerify'";
        $result = $conn->query($sql);

        header("Location: ../Login.php?error=4");
        exit();
    }
    else{
        header("Location: ../Login.php?error=5");
        exit();
    }

?>