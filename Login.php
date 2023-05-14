<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./imgs/svg/logo-no-background.svg">
    <link rel="stylesheet" href="./styles/styleLogin.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title>Login</title>
</head>
<body data-barba="wrapper">
    <main data-barba="container" data-barba-namespace="login">
        <section class="sectionSingUp">  
            <div class="formContainer">
            <?php
                require_once __DIR__ . '/Convalidation/Config.php';
            ?>
                <form action="Convalidation/convalidateLogin.php" method="post" class="loginForm" id="frm"> 
                    <h2>Login</h2> 
                    <label for="username">Username:</label> 
                    <input type="text" id="username" name="username" required> 
                    <label for="password">Password:</label> 
                    <input type="password" id="password" name="password" required> 

                    <?php
                        if(isset($_GET["error"])){
                            if($_GET["error"] == 1){
                                echo "<p class='error'>Username o password errati</p>";

                                echo  "<script>
                                        document.getElementById('username').style.border = '1px solid red';
                                        document.getElementById('password').style.border = '1px solid red';
                                    </script>";
                            }
                            else if($_GET["error"] == 2){
                                echo "<p class='error'>Captcha non superato</p>";
                            }
                        }
                    ?>

                    <div class="row">
                    <input type="submit" class="g-recaptcha full-width"
                        data-sitekey="<?php echo Config::GOOGLE_RECAPTCHA_SITE_KEY; ?>"
                        data-callback='onSubmit' data-action='submit'
                        value="Accedi" 
                        id="btninp"
                        style="">
                    </div>
                    <!-- <input type="submit" value="Accedi"> -->
                    <a href="./SingUp.php" class="linkReg"> Non hai un account? Registrati!</a>

                </form> 
            </div>
            <div class="decorationDiv"></div>
            <div class="decorationInt"></div>
            <div class="secondDecorationDiv"></div>
            <div class="secondIntDecorationDiv"></div> 
        </section> 
    </main>
    <script type="module" src="./scripts/main.js"></script>

    <script>
// JavaScript
        function onSubmit(token) {
            var button = document.createElement('input');
            button.type = 'hidden';
            button.name = 'recaptcha_token';
            button.value = token;

            var form = document.getElementById("frm");
            form.appendChild(button);
            form.submit();
        }
    </script>

</body>
</html>