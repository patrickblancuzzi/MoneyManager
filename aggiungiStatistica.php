<?php
    $data = $_POST['data'];
    $uscita = $_POST['uscita'];
    $entrata = $_POST['entrata'];
    $pan = $_POST['pan'];

    if($_POST['entrata'] == ""){
        $entrata = 0;
    }

    if($_POST['uscita'] == ""){
        $uscita = 0;
    }

    $uscita = floatval($uscita);
    $entrata = floatval($entrata);

    include "dbConnection.php";

    $data = mysqli_real_escape_string($conn, $data);
    $pan = mysqli_real_escape_string($conn, $pan);
    $uscita = mysqli_real_escape_string($conn, $uscita);
    $entrata = mysqli_real_escape_string($conn, $entrata);

    $data = date('d-m-Y', strtotime($data));
    $data = str_replace('-', '/', $data);

    $sql = "SELECT * FROM Statistica WHERE Data = '$data' AND Carta = '$pan'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $uscita += $row['Uscita'];
            $entrata += $row['Entrata'];
        }

        $sql = "UPDATE Statistica SET Uscita = '$uscita', Entrata = '$entrata' WHERE Data = '$data' AND Carta = '$pan'";
        if($conn->query($sql) === TRUE){
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    else{
        $sql = "INSERT INTO Statistica (Data, Uscita, Entrata, Carta) VALUES ('$data', '$uscita', '$entrata', '$pan')";

        if($conn->query($sql) === TRUE){
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
    }

    // Contenuti da inviare

    // Genera il modulo HTML con il campo di input nascosto
    echo '<form id="myForm" action="carta.php" method="post">';
    echo '<input type="hidden" name="pan" value="' . $pan . '">';
    echo '</form>';

    // Invia il modulo automaticamente utilizzando JavaScript
    echo '<script>document.getElementById("myForm").submit();</script>';
?>