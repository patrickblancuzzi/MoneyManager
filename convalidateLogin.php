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

        $usernameForm = mysqli_real_escape_string($conn, $usernameForm);
        $passwordForm = mysqli_real_escape_string($conn, $passwordForm);

        $sql = "SELECT * FROM Utente WHERE Username = '$usernameForm'";

        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            if($row["FlagVerifica"] == 1){
                header("Location: ../Login.php?error=3");
                exit();
            }

            $password = $row["Password"];

            if(password_verify($passwordForm, $password)){
                session_start();

                $_SESSION["username"] = $usernameForm;

                header("Location: ../index.php");
                exit();
            }else{
                header("Location: ../Login.php?error=1");
                exit();
            }
        }
        else{
            header("Location: ../Login.php?error=1");
            exit();
       }
    } else {
        header("Location: ../Login.php?error=2");
        exit();
    }
?>