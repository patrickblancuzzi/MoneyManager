<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./imgs/svg/logo-no-background.svg">
    <link rel="stylesheet" href="./styles/styleSingUp.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title>SingUp - Money Manager</title>
</head>
<body data-barba="wrapper"> 
    <main data-barba="container" data-barba-namespace="SingUp">
        <section class="sectionSingUp">  
            <div class="formContainer">
                <?php
                    require_once __DIR__ . '/Convalidation/Config.php';
                ?>
                <form action="Convalidation/convalidateRegister.php" method="post" class="loginForm" id="frm"> 
                    <h2>Registrati</h2> 
                    <label for="name">Username:</label> 
                    <input type="text" id="username" name="username" required> 

                    <?php
                        if(isset($_GET["error"])){
                            if($_GET["error"] == 3){
                                echo "<p class='error'>Username già in uso</p>";

                                echo  "<script>
                                        document.getElementById('username').style.border = '1px solid red';
                                    </script>";
                            }
                        }
                    ?>

                    <label for="age">Età</label>
                    <input type="number" id="age" name="age" required min="0">

                    <?php
                        if(isset($_GET["error"])){
                            if($_GET["error"] == 1){
                                echo "<p class='error'>Devi avere almeno 18 anni per registrarti</p>";

                                echo  "<script>
                                        document.getElementById('age').style.border = '1px solid red';
                                    </script>";
                            }
                        }
                    ?>
                    <label for="email">Email:</label> 
                    <input type="email" id="email" name="email" required> 
                    <label for="password">Password:</label> 
                    <input type="password" id="password" name="password" required> 
                    <label for="passwordConferma">Conferma Password:</label> 
                    <input type="password" id="passwordConferma" name="passwordConferma" required> 

                    <?php
                        if(isset($_GET["error"])){
                            if($_GET["error"] == 2){
                                echo "<p class='error'>Le password non coincidono</p>";

                                echo  "<script>
                                        document.getElementById('password').style.border = '1px solid red';
                                        document.getElementById('passwordConferma').style.border = '1px solid red';
                                    </script>";
                            }

                            if($_GET["error"] == 4){
                                echo "<p class='error'>La password deve contenere almeno 8 caratteri</p>";

                                echo  "<script>
                                        document.getElementById('password').style.border = '1px solid red';
                                        document.getElementById('passwordConferma').style.border = '1px solid red';
                                    </script>";
                            }
                            if($_GET["error"] == 5){
                                echo "<p class='error'>Captcha non superato, aggiorna la pagina</p>";
                            }
                        }
                    ?>

                    <div class="row">
                    <input type="submit" class="g-recaptcha full-width"
                        data-sitekey="<?php echo Config::GOOGLE_RECAPTCHA_SITE_KEY; ?>"
                        data-callback='onSubmit' data-action='submit'
                        value="Registrati" 
                        id="btninp"
                        style="">
                    </div>
                    <!-- <input type="submit" value="Registrati"> -->
                    <a href="./Login.php" class="linkReg"> Login</a>
                </form> 
            </div>
            <div class="decorationDiv"></div>
            <div class="decorationInt"></div>
            <div class="secondDecorationDiv"></div>
            <div class="secondIntDecorationDiv"></div>
        </section> 
    </main>
    <script type="module" src="./scripts/singUpAnimation.js"></script>

        <script>
        function onSubmit(token) {
            var button = document.createElement('input');
            button.type = 'hidden';
            button.name = 'recaptcha_token';
            button.value = token;

            var form = document.getElementById("frm");
            form.appendChild(button);
            form.submit();
        }

        var inputBox = document.getElementById("age");

        var invalidChars = [
        "-",
        "+",
        "e",
        ];

        inputBox.addEventListener("input", function() {
        this.value = this.value.replace(/[e\+\-]/gi, "");
        });

        inputBox.addEventListener("keydown", function(e) {
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }
        });
    </script>
</body>
</html>