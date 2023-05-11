<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./imgs/svg/logo-no-background.svg">
    <link rel="stylesheet" href="./styles/styleSingUp.css">
    <title>SingUp - Money Manager</title>
</head>
<body data-barba="wrapper"> 
    <main data-barba="container" data-barba-namespace="SingUp">
        <section class="sectionSingUp">  
            <div class="formContainer">
                <form action="" method="post" class="loginForm"> 
                    <h2>Registrati</h2> 
                    <label for="name">Username:</label> 
                    <input type="text" id="username" name="username" required> 
                    <label for="age">Età</label>
                    <input type="number" id="age" name="age" required>
                    <label for="password">Password:</label> 
                    <input type="password" id="password" name="password" required> 
                    <label for="passwordConferma">Conferma Password:</label> 
                    <input type="password" id="passwordConferma" name="passwordConferma" required> 
                    <input type="submit" value="Registrati"> 
                    <a href="./login.php" class="linkReg"> Login</a>
                </form> 
            </div>
            <div class="decorationDiv"></div>
            <div class="decorationInt"></div>
            <div class="secondDecorationDiv"></div>
            <div class="secondIntDecorationDiv"></div>
        </section> 
    </main>

    <script type="module" src="./scripts/singUpAnimation.js"></script>
</body>
</html>