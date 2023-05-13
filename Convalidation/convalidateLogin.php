<?php
    $usernameForm = $_POST["username"];
    $passwordForm = $_POST["password"];

    include "../dbConnection.php";

    $sql = "SELECT * FROM Utente WHERE Username = '$usernameForm'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        $password = $row["Password"];

        if(password_verify($passwordForm, $password)){
            session_start();

            $_SESSION["username"] = $usernameForm;

            header("Location: ../index.php");
        }else{
            header("Location: ../Login.php?error=1");
        }
    }
    else{
        header("Location: ../Login.php?error=1");
    }

?>