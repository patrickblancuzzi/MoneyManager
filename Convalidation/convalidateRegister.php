<?php
    $usernameForm = $_POST["username"];
    $age = $_POST["age"];
    $passwordForm = $_POST["password"];
    $passwordConferma = $_POST["passwordConferma"];
    $email = $_POST["email"];

    $age = intval($age);

    echo "<script> console.log('$usernameForm') </script>";

    if($age < 18){
        header("Location: ../SingUp.php?error=1");
    }
    
    if(strlen($passwordForm) < 8){
        header("Location: ../SingUp.php?error=4");
    }

    if($passwordForm != $passwordConferma){
        header("Location: ../SingUp.php?error=2");
    }

    include "../dbConnection.php";

    $sql = "SELECT * FROM Utente WHERE Username = '$usernameForm'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        header("Location: ../SingUp.php?error=3");
    }

    $randomBytes = random_bytes(10);
    $randomString = bin2hex($randomBytes);
    $randomString = substr($randomString, 0, 10);
    echo $randomString;

    $flag = 1;

    $passwordForm = password_hash($passwordForm, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Utente (Username, Password, Email, CodiceVerifica, FlagVerifica) VALUES ('$usernameForm', '$passwordForm', '$email', '$randomString', '$flag')";
    $result = $conn->query($sql);

    $conn->close();

    header("Location: ../Login.php");
?>