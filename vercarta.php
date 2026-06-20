<!DOCTYPE html>
<html lang="en">
<?php
include("conexao.php");
session_start();

// Recebe o id da carta clicada no index via POST (form), nunca via GET/URL.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_carta']) && ctype_digit((string) $_POST['id_carta'])) {
    $_SESSION['view_id'] = (int) $_POST['id_carta'];
}

// Se não houver nenhum id válido na sessão (acesso direto à página), volta pro index.
if (empty($_SESSION['view_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['view_id'];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crimsom Beast</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .page-header p {
            font-size: .95rem;
        }

        h7 {
            font-size: 1.2rem;
            font-weight: bold;
        }

        img.foto {
            width: 300px;
        }

        .card-art-link {
            margin: 0;
        }

        .card-art-btn {
            width: 100%;
            height: 100%;
            border: none;
            background: none;
            padding: 0;
            margin: 0;
            cursor: pointer;
            display: block;
        }

        .page-wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem .75rem;
            flex: 1;
        }
    </style>
</head>

<body>
    <?php
    include("navbar.php");

    // pega via PDO usando o id da sessão
    $sql = 'SELECT * FROM cartas WHERE id_CARTA = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo '<p>Nenhuma carta encontrada.</p>';
    } else {
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $dados['ID_CARTA'];
        $nome = $dados['NOME'];
        $imagem = $dados['IMAGEM'];
        $sangue = $dados['SANGUE'];
        $raridade = $dados['RARIDADE'];
        $lendario = $dados['LENDARIO'];
        $lendariotext = ($lendario === 's') ? "lendário" : "";
        $colecao = $dados['COLECAO'];
        $preco = $dados['PRECO'];
    }
    ?>
    <div class="page-wrap">
        <div class="card-wrap">
            <div class="card-header-bar">
                <span class="card-name">
                    <h4 class="card-title">
                        <?php echo htmlspecialchars($nome ?? '') ?>
                    </h4>
                </span>
                <span class="badge-rarity rarity-<?php echo htmlspecialchars($raridade) ?>"></span>
            </div>
            <div class=" card-art">
                <form action="vercarta.php" method="POST" class="card-art-link">
                    <input type="hidden" name="id_carta" value="<?= (int) $row['ID_CARTA'] ?>">
                    <button type="submit" class="card-art-btn">
                        <img src="<?php echo htmlspecialchars($imagem ?? 'img/logo.png') ?>" class="foto"
                            alt="<?php echo htmlspecialchars($nome ?? '') ?>">">
                    </button>
                </form>
            </div>
            <div class="card-footer-bar">
                <span class="card-edition">Coleção: <?= htmlspecialchars($colecao) ?></span>
                <span class="card-price">R$: <?= htmlspecialchars($preco) ?></span>
            </div>
            <div class="card-actions">
                <div class="card-counter">
                    <button class="counter-btn" onclick="changeQty(this, -1)">−</button>
                    <span class="counter-qty">0</span>
                    <button class="counter-btn" onclick="changeQty(this, 1)">+</button>
                </div>
                <button class="btn-lista">+Lista</button>
            </div>
        </div>
    </div>
    <footer class="">
        <div class="container">
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