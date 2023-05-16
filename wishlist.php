<?php
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
    <link rel="stylesheet" href="./styles/styleWishlist.css">
    <link rel="icon" type="image/x-icon" href="./imgs/svg/logo-no-background.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    
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
                    <a href="./wishlist.php">
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
        <div class="contentForm">
            <form class="formWish" action="aggiungiProdotto.php" method="post">
                <h2>Aggiungi prodotto:</h2>
                <div class="content">
                    <label for="name"></label>
                    <input type="text" name="name" id="name" placeholder="Nome" required>
                    <label for="categoria"></label>
                    <input type="text" name="categoria" id="categoria" placeholder="Categoria" required>
                    <label for="prezzo"></label>
                    <input type="number" step="any" name="prezzo" id="prezzo" placeholder="Prezzo" required>
                    <button class="buttonCrea"type="submit">CREA</button>
                </div>
            </form>
        </div>
    </section>
    <section class="relativeSection">
        <table>
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Categoria</th>
                <th scope="col">Costo</th>
                <th scope="col">Quantità</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include 'dbConnection.php';

                    $sql = "SELECT * FROM Prodotto WHERE UserWishlist = '".$_SESSION['username']."'";

                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo "
                                <tr>
                                <td data-label='Nome'>" . $row['Nome'] . "</td>
                                <td data-label='Categoria'>" . $row['Categoria'] . "</td>
                                <td data-label='Costo'>" . sprintf("%.2f", $row['Prezzo']) . " €</td>
                                <td data-label='Quantità'>" . $row['Quantita'] . "</td>
                                <form action='eliminaProdotto.php' method='post'>
                                    <input type='hidden' name='nome' value='".$row['Nome']."'>
                                    <td><button type='submit'><img class='icon' src='./imgs/svg/rubbish-bin-svgrepo-com.svg' alt='bin'></button></td>
                                </form>
                                </tr>
                            ";
                        }
                    }
                ?>
            </tbody>
        </table>
    </section>
    </body>
</html>