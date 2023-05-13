<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./imgs/svg/logo-no-background.svg">
    <link rel="stylesheet" href="./styles/styleLogin.css">
    <title>Login - Money Manager</title>
</head>
<body data-barba="wrapper">
    <main data-barba="container" data-barba-namespace="login">
        <section class="sectionSingUp">  
            <div class="formContainer">
                <form action="Convalidation/convalidateLogin.php" method="post" class="loginForm"> 
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
                        }
                    ?>

                    <input type="submit" value="Accedi"> 
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
</body>
</html>