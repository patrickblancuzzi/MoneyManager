<?php
    require_once 'Config.php';

    $reCaptchaToken = $_POST['recaptcha_token'];

    $postArray = array(
        'secret' => Config::GOOGLE_RECAPTCHA_SECRET_KEY,
        'response' => $reCaptchaToken
    );

    $postJSON = http_build_query($postArray);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postJSON);
    $response = curl_exec($curl);
    curl_close($curl);

    $curlResponseArray = json_decode($response, true);

    if ($curlResponseArray["success"] == true && $curlResponseArray["score"] >= 0.5) {
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
    } else {
        header("Location: ../Login.php?error=2");
    }
?>