<?php
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: ./Login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panoramica - Money Manager</title>
    <link rel="stylesheet" href="./styles/panoramica.css">
    <link rel="icon" type="image/x-icon" href="./imgs/svg/logo-no-background.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
        <nav>
            <input id="nav-toggle" type="checkbox">
            <ul class="links">
                <li class="itemList">
                    <div class="itemListNav">
                    <a class="active" href="./index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
                    </svg> 
                    HOME  
                    </a>
                    </div>
                </li>
                <li class="itemList">
                    <a href="wishlist.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-heart" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5Zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0ZM14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1ZM8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
                        </svg>   
                        Wishlist 
                    </a>
                </li>
                <li class="itemList">
                    <a href="./profilo.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        </svg>  
                        Profilo 
                    </a>
                </li>
            </ul>
        <label for="nav-toggle" class="icon-burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>
    </nav>

    <section class="relativeSectionFirst">
        <div class="contentGrafico">
            <canvas class="grafico" id="grafico"></canvas>

            <?php
                include "dbConnection.php";

                $saldoCorrente = 0;
                $speseTotali = 0;
                $entrateTotali = 0;

                $sql = "SELECT *
                FROM Carta JOIN Statistica ON Carta.PAN = Statistica.Carta
                WHERE Carta.User = '" . $_SESSION['username'] . "'";    

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $speseTotali += $row['Uscita'];
                        $entrateTotali += $row['Entrata'];
                    }
                }
                $saldoCorrente = $entrateTotali - $speseTotali;
            ?> 
        </div>

        <div class="statistiche">
            <div class="itemStatistiche">
                <h2>Saldo Corrente: </h2>
                <p><?php echo sprintf("%.2f", $saldoCorrente) ?> €</p>
            </div>
            <div class="itemStatistiche">
                <h2>Spese totali: </h2>
                <p id="spese"><?php echo sprintf("%.2f", $speseTotali) ?> €</p>
            </div>
            <div class="itemStatistiche">
                <h2>Entrate totali: </h2>
                <p id="guadagno"><?php echo sprintf("%.2f", $entrateTotali) ?> €</p>
            </div>
        </div>
    </section>

    <section class="relativeSection">
    <?php
            include "dbConnection.php";

            $username = mysqli_real_escape_string($conn, $_SESSION["username"]);
            $query = "SELECT * FROM Carta WHERE User = '$username'";            

            $result = mysqli_query($conn, $query);

            echo "<div class='containerCards'>";

            if(isset($_GET["error"])){
                if($_GET["error"] == 1){
                    echo "<center><p class='error'> Errore nella creazione della carta, PAN già esistente</p></center>";
                }
                if($_GET["error"] == 2){
                    echo "<center><p class='error'> Errore nella creazione della carta, CVV non valido</p></center>";
                }
                if($_GET["error"] == 3){
                    echo "<center><p class='error'> Errore nella creazione della carta, PAN non valido</p></center>";
                }
                if($_GET["error"] == 4){
                    echo "<center><p class='error'> Errore nella creazione della carta, Data di scadenza non valida</p></center>";
                }
            }

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "
                    <div class='containerCards'>
                        <div class='card'>
                            <div class='card__front card__part'>
                                <img class='card__front-square card__square' src='./imgs/png/PayPal-Logo.png'>
                                <p class='card_numer'>" . chunk_split($row["PAN"], 4, " ") . "</p>
                                <div class='card__space-75'>
                                <span class='card__label'>Titolare:</span>
                                <p class='card__info'>" . $row["Titolare"] . "</p>
                                </div>
                                <div class='card__space-25'>
                                <span class='card__label'>Scadenza</span>
                                        <p class='card__info'>" . $row["DataScadenza"] . "</p>
                                </div>
                            </div>             
                            <div class='card__back card__part'>
                                <div class='card__black-line'></div>
                                <div class='card__back-content'>
                                <div class='card__secret'>
                                    <p class='card__secret--last'>" . $row["CVV"] . "</p>
                                </div>
                                <img class='card__back-square card__square' src='./imgs/png/PayPal-Logo.png'>
                                </div>
                            </div>
                        </div>
                        <div class='buttons'>
                            <div class='buttonsCard'>
                                <form method='post' action='carta.php'>
                                <input type='hidden' name='pan' value='" . $row["PAN"] . "'>
                                <input class='buttonVai' type='submit' value='Vai alla carta'>
                            </form>
                            </div>
                            <div class='buttonsCard'>
                                <form method='post' action='eliminaCarta.php?pan=" . $row["PAN"] . "'>
                                    <input type='submit' value='Elimina Carta' class='buttonElimina'>
                                </form>
                            </div>
                    </div>
                ";
                }
            }
        ?>

            <div class="cardNew" onclick="cambioContent()">
                <button class="buttonNew" id="buttonNew" onclick="cambioContent()">+</button>
                <div class="displayNone transition" id="formDivContent">
                    <form class="formContent" id="cardNew" action="addCard.php" method="post">
                    <label for="nomeTitolare">Nome titolare:</label>
                        <input type="text" name="nomeTitolare" id="nomeTitolare" required>
                        <label for="pan">Pan:</label>
                        <input type="text" name="pan" id="pan" required>
                        <label for="dataScadenza">Data di Scadenza:</label>
                        <input type="month" name="dataScadenza" id="dataScadenza" required>
                        <label for="cvv">CVV:</label>
                        <input type="text" name="cvv" id="cvv" required>
                        <button type="submit" class="buttonVai">Crea</button>
                    </form>
                        <button class="buttonBack" onclick="cambioContentBack()" id="buttonBack">Indietro</button>
                </div>
            </div>
        </div>
    </section>

    <?php
    ?>

    <script>
        let button = document.getElementById("buttonNew");
        let card = document.getElementById("cardNew");
        let button2 = document.getElementById("buttonBack")
        let form = document.getElementById("formDivContent");

        function cambioContent(){
            button.classList.add("displayNone");
            form.classList.remove("displayNone")
        }

        function cambioContentBack(){
            button.classList.remove("displayNone");
            form.classList.add("displayNone")
        }

        //window.addEventListener('load', function(){
        // Dati di esempio
        var guadagno = document.getElementById("guadagno").innerHTML;
        var spese = document.getElementById("spese").innerHTML;

        guadagno = parseInt(guadagno.replace(" €", ""));
        spese = parseInt(spese.replace(" €", ""));

        // Calcola la percentuale di guadagno e spese
        var percentualeGuadagno = (guadagno / (guadagno + spese)) * 100;
        var percentualeSpese = (spese / (guadagno + spese)) * 100;

        // Configurazione del grafico
        var config = {
            type: 'pie',
            data: {
                labels: ['Guadagno', 'Spese'],
                datasets: [{
                    data: [percentualeGuadagno, percentualeSpese],
                    backgroundColor: ['green', 'red']
                }]
            },
            options: {
                responsive: true
            }
        };

        // Creazione del grafico
        var ctx = document.getElementById('grafico').getContext('2d');
        new Chart(ctx, config);
        //})
    </script>
</body>
</html>