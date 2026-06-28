<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacotinho</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include("navbar.php");
          include("conexao.php"); ?>

    <!-- Ordinários 50% (1-50)
Excepcionais 30% (51-80)
Elite 13% (81-93)
Único   5% (94-98)
Desespero 2% (99-100) -->

    
    <div class="page-wrap">
        <div class="page-header">
            <div>
                <h1 class="">Simulador de Pacotinho!</h1>
                <?php
                $jaforam = [];
                $jaforam = array_fill(0, 9, '');
                $i = 1;
                while ($i <= 9) {
                    $rand = rand(1,100);
                    $raridade = "";
                    if ($rand <=100) {
                        $raridade = "desespero";
                    }
                    if ($rand <=98) {
                        $raridade = "unico";
                    }
                    if ($rand <=93) {
                        $raridade = "elite";
                    }
                    if ($rand <=80) {
                        $raridade = "excepcional";
                    }
                    if ($rand <=50) {
                        $raridade = "ordinario";
                    }
                    $stmt = $conn->prepare('SELECT * FROM cartas WHERE raridade LIKE :raridade ');
                    $stmt->bindValue(':raridade', '%' . $raridade . '%', PDO::PARAM_STR);
                    $stmt->execute();
                    $cartas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $cartaAleatoria = $cartas[array_rand($cartas)];
                    if(in_array( $cartaAleatoria["ID_CARTA"],$jaforam )){
                        continue;
                    }
                    else{
                        $jaforam[$i-1]=$cartaAleatoria["ID_CARTA"];
                    }
                    echo "<p style = 'fontweight: bold'>";
                    echo $raridade . ": " . $cartaAleatoria['NOME'];
                    echo "</p>";
                    $i++;
                }
                ?>
            </div>
        </div>
    </div>
    <footer class="">
        <div class="container ">
            <p>&copy; 2026 Crimsom Beast. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>