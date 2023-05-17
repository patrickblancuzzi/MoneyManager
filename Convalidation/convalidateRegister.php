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
        $age = $_POST["age"];
        $passwordForm = $_POST["password"];
        $passwordConferma = $_POST["passwordConferma"];
        $email = $_POST["email"];

        $age = intval($age);

        echo "<script> console.log('$usernameForm') </script>";

        if($age < 18){
            header("Location: ../SingUp.php?error=1");
            exit();
        }
        
        if(strlen($passwordForm) < 10){
            header("Location: ../SingUp.php?error=4");
            exit();
        }

        if($passwordForm != $passwordConferma){
            header("Location: ../SingUp.php?error=2");
            exit();
        }

        include "../dbConnection.php";

        //check input not sql injection
        $usernameForm = mysqli_real_escape_string($conn, $usernameForm);
        $passwordForm = mysqli_real_escape_string($conn, $passwordForm);
        $passwordConferma = mysqli_real_escape_string($conn, $passwordConferma);
        $email = mysqli_real_escape_string($conn, $email);

        $sql = "SELECT * FROM Utente WHERE Username = '$usernameForm'";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            header("Location: ../SingUp.php?error=3");
            exit();
        }

        $randomBytes = random_bytes(10);
        $randomString = bin2hex($randomBytes);
        $randomString = substr($randomString, 0, 10);

        $flag = 1;

        $passwordForm = password_hash($passwordForm, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Utente (Username, Password, Email, CodiceVerifica, FlagVerifica) VALUES ('$usernameForm', '$passwordForm', '$email', '$randomString', '$flag')";
        $result = $conn->query($sql);

        $conn->close();

        setlocale(LC_TIME, 'it_IT');

        // Imposta l'intestazione della mail
        $headers = "From: moneymanager@registration.com\r\n";
        $headers .= "Reply-To: moneymanager@registration.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $to = $email;
        $subject = "Verifica il tuo account!";
        $message = "
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        </head>
        <body>
            <div style='font-size: 14px !important;background-color: #eee; padding: 40px; font-family: Arial;'>
            <div style='width:550px; min-width: 550px;max-width:550px;margin:0 auto;box-sizing:border-box;'>
                <div style='width: 100%;border:1px solid #e0e0e0; background-color:white;padding: 20px;color:#444;box-sizing:border-box;'>
                    <div style='text-align:center'>
                        <img height='40' style='margin-top: 10px;' src='data:image/png;base64,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'>
                        <h2 style='font-size: 20px;'>Benvenuto in Money Manager!</h2>
                    </div>
                    <hr style='border: 1px solid #efefef'>
                    <p>Conferma la tua email per ottenere l'accesso al sito! Se non hai sottoscritto nessuna registrazione clicca <a href='blancuzzi.bearzi.info/MoneyManager/Convalidation/destroyAccount.php?un=" . $usernameForm . "'>QUI!</a> </p>
                    <h4>Informazioni del tuo account</h4>
                    <table>
                        <tr>
                            <td width='100' style='padding-bottom: 10px'>Data:</td>
                            <td style='padding-bottom: 10px'><strong>" . $date = date('d-m-Y H:i:s') . "</strong></td>
                        </tr>
                        <tr>
                            <td style='padding-bottom: 10px'>IP address:</td>
                            <td style='padding-bottom: 10px'><strong>" . $_SERVER['REMOTE_ADDR'] . "</strong></td>
                        </tr>
                        <tr>
                            <td style='padding-bottom: 10px'>Età:</td>
                            <td style='padding-bottom: 10px'><strong>" . $age . "</strong></td>
                        </tr>
                        <tr>
                            <td style='padding-bottom: 10px'>Username:</td>
                            <td style='padding-bottom: 10px'><strong>" . $usernameForm . "</strong></td>
                        </tr>
                    </table>
                    <br>
                    <hr style='border: 1px solid #efefef; margin-bottom: 24px;'>
                    <p>Perfavore controlla che l'IP il browser e il device corrispondano al tuo. Se corretti procedi con l'autenticazione. </p>
                    <br>
                    <div style='text-align:center'>
                        <a href='blancuzzi.bearzi.info/MoneyManager/Convalidation/autenticateAccount.php?code=" . $randomString . "&username=" . $usernameForm . "' target='_blank' style='background:#007bff; color: white; border-radius: 3px; padding: 13px 18px;text-decoration:none'>VERIFICA L'ACCOUNT</a>
                        <br><br>
                    </div>
                </div>
                <div style='text-align:center;background-color:#f7f7f7;border: 1px solid #e0e0e0;box-sizing:border-box;padding:10px;border-top: none!important'>
                    <a href='blancuzzi.bearzi.info/MoneyManager'><p style='margin: 10px'><strong>moneymanager.com</strong></p></a>
                    <p style='margin: 10px; line-height: 20px;'>Istituto Salesiano G. Bearzi (Istituto Tecnico Informatico e Meccatronico), Via Don Giovanni Bosco, 2, 33100 Udine UD</p>
                    <a href='#'>Contattaci</a>
                </div>
            </div>
        </div>
        </body>
        ";
        
        // Invia la mail
        if (mail($to, $subject, $message, $headers)) {
            echo "Mail inviata con successo";
        } else {
            echo "Errore nell'invio della mail";
        }
        

        header("Location: ../Login.php");
    } else {
        header("Location: ../SingUp.php?error=5");
    }
?>