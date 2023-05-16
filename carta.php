<?php
    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: index.php");
    }

    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: Login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta - Money Manager</title>
    <link rel="stylesheet" href="./styles/styleCard.css">
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
                    <a href="#">
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
    <section class="relativeSection">
        <div class="contentGrafico">
        <canvas id="grafico"></canvas>
        </div>

        <?php
            include "dbConnection.php";

            $saldoCorrente = 0;
            $speseTotali = 0;
            $entrateTotali = 0;

            $pan = $_POST['pan'];

            $sql = "SELECT * FROM Statistica WHERE Carta = '$pan'";

            $result = $conn->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $speseTotali += $row['Uscita'];
                    $entrateTotali += $row['Entrata'];
                }
            }

            $saldoCorrente = $entrateTotali - $speseTotali;
            
            $nomeCarta = substr($pan, -4); 
        ?>

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
                <h2>Entrate totali </h2>
                <p id="guadagno"><?php echo sprintf("%.2f", $entrateTotali) ?> €</p>
            </div>
        </div>
    </section>
    <section class="relativeSection">
        <table>
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Entrata</th>
                <th scope="col">Uscita</th>
                <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                        $sql = "SELECT * FROM Statistica WHERE Carta = '$pan'";

                        $result = $conn->query($sql);

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                echo "
                                <td data-label='Nome'>Visa - " . $nomeCarta . "</td>
                                <td data-label='Entrata'>" . sprintf("%.2f", $row["Entrata"]) . " €</td>
                                <td data-label='Uscita'>" . sprintf("%.2f", $row["Uscita"]) . " €</td>
                                <td data-label='Giorno'>" . $row["Data"] . "</td>
                                </tr>
                                ";
                            }
                        }
                    ?>
            </tbody>
        </table>
    </section>

    <script>
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