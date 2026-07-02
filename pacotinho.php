<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacotinho</title>
    <link rel="icon" type="image/x-icon" href="img/logo.ico">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .pacotinho-card {
            background: #1e1e1e;
            border: 1px solid #333;
            border-radius: 14px;
            padding: 1.5rem 2rem;
            max-width: 420px;
            margin: 1.5rem auto 0;

        }

        .item-raridade {

            margin: 0.35rem 0;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .pacotinho-card .item-raridade {
            opacity: 1 !important;
            filter: none !important;
        }

        .pacotinho-card .item-ordinario {
            color: #ffffff !important;
        }

        .pacotinho-card .item-excepcional {
            color: #2ecc71 !important;
        }

        .pacotinho-card .item-elite {
            color: #f39c12 !important;
            text-shadow: 0 0 6px rgba(243, 156, 18, 0.4);
        }

        .pacotinho-card .item-unico {
            color: #a569f5 !important;
            text-shadow: 0 0 6px rgba(165, 105, 245, 0.4);
        }

        .pacotinho-card .item-desespero {
            color: #ff4c4c !important;
            font-weight: 800;
            text-shadow: 0 0 8px rgba(255, 76, 76, 0.6);
        }
    </style>
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
                <div class="pacotinho-card">
                    <?php
                    $jaforam = [];
                    $jaforam = array_fill(0, 9, '');
                    $i = 1;
                    while ($i <= 9) {
                        $rand = rand(1, 100);
                        $raridade = "";
                        if ($rand <= 100) {
                            $raridade = "desespero";
                        }
                        if ($rand <= 98) {
                            $raridade = "unico";
                        }
                        if ($rand <= 93) {
                            $raridade = "elite";
                        }
                        if ($rand <= 80) {
                            $raridade = "excepcional";
                        }
                        if ($rand <= 50) {
                            $raridade = "ordinario";
                        }
                        $stmt = $conn->prepare('SELECT * FROM cartas WHERE raridade LIKE :raridade ');
                        $stmt->bindValue(':raridade', '%' . $raridade . '%', PDO::PARAM_STR);
                        $stmt->execute();
                        $cartas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $cartaAleatoria = $cartas[array_rand($cartas)];
                        if (in_array($cartaAleatoria["ID_CARTA"], $jaforam)) {
                            continue;
                        } else {
                            $jaforam[$i - 1] = $cartaAleatoria["ID_CARTA"];
                        }
                        echo "<p class='item-raridade item-" . $raridade . "'>";
                        echo $raridade . ": " . htmlspecialchars($cartaAleatoria['NOME']);
                        echo "</p>";
                        $i++;
                    }
                    ?>

                </div>

                <a class="btn-toolbar mt-3" href="pacotinho.php">Reload</a>

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