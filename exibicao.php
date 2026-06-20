<!DOCTYPE html>
<html lang="en">
<?php include("conexao.php") ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crimsom Beast</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: var(--bg-white);
            padding-top: 70px;
        }

        nav {
            background-color: var(--bg-secondary);
        }

        .page-header p {
            font-size: .95rem;
        }

        h7 {
            font-size: 1.2rem;
            font-weight: bold;
        }
        img.foto{
            width: 300px;
        }
    </style>
</head>

<body>


    <nav class="navbar fixed-top navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="ms-2 navbar-brand" href="index.php">
                <img src="img/logo.png" alt="Logo" width="60" height="50" class="d-inline-block align-itens-end">
                <b>Crimsom Beast</b>
            </a>
            <a class="navbar-brand me-5" href="login.php">
                <img src="img/login.png" alt="Logo" width="45" height="45" class="d-inline-block align-itens-end ">
                <h7>Login</h7>
            </a>
        </div>
    </nav>
    <?php
    $sql = 'SELECT * FROM cartas WHERE id_CARTA = 1';
    $query = $conn->query($sql);

    if ($query->rowCount() === 0) {
        echo '<p>Nenhuma carta encontrada.</p>';
    } else {
        $dados = $query->fetch();
        $nome = $dados['NOME'];
        $imagem = $dados['IMAGEM'];
        $sangue = $dados['SANGUE'];
        $raridade = $dados['RARIDADE'];
        $lendario = $dados['LENDARIO'];
        $lendariotext = $lendario ? "lendario" : "";
        $colecao = $dados['COLECAO'];
        $preco = $dados['PRECO'];
    }
    ?>
    <div class="">
        <div class="card mx-auto w-50">
            <div class="container-fluid card-body text-center ">
                <div class="row">
                    <div class="col-5">
                        <img src="img/logo.png" class="foto" alt="<?php echo $nome?>">
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h4 class="card-title"><?php echo $nome?></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><b>Raridade:</b> <?php echo $raridade . " " . $lendariotext ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><b>Sangue:</b> <?php echo $sangue?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><b>Coleção:</b> <?php echo $colecao?></p>
                                <p><b>Preço:</b> R$ <?php echo number_format($preco, 2, ",", ".")?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="row mb-3">
                                    <div class="col">
                                        <button class="counter-btn" onclick="changeQty(this, -1)">−</button>
                                        <span class="counter-qty">0</span>
                                        <button class="counter-btn" onclick="changeQty(this, 1)">+</button>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col">
                                        <button class="btn-lista">+Lista</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="">
        <div class="container ">
            <p>&copy; 2026 Crimsom Beast. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
<script src="script.js"></script>
<script>
    function changeQty(btn, delta) {
        const qtyEl = btn.parentElement.querySelector('.counter-qty');
        let qty = parseInt(qtyEl.textContent) + delta;
        if (qty < 0) qty = 0;
        qtyEl.textContent = qty;
        qtyEl.classList.toggle('counter-qty--active', qty > 0);
    }
</script>

</html>