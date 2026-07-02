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
        .carta-layout {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: stretch;
            justify-content: center;
            gap: 2rem;
        }

        /* Imagem*/
        .carta-imagem-box {
            flex: 0 1 280px;
            /* base de 280px, pode encolher até um mínimo */
            min-width: 100px;
            max-width: 100%;
            border: 3px solid #000;
            border-radius: 12px;
            overflow: hidden;
            background: #000000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carta-imagem-box img {
            width: 100%;
            height: 100%;
        }

        /* Painel do formulário*/
        .carta-info-panel {
            flex: 2 1 250px;
            /* ocupa mais espaço, base de 380px */
            min-width: 200px;
            max-width: 500px;
            margin: 0;
            background: var(--bg-card);
            /* #1c1c1c */
            border: 1.5px solid var(--color-crimson-dark);
            border-radius: 16px;
            padding: 1.5rem 2rem 2rem;
            display: flex;
            flex-direction: column;
        }

        /* Títulos e labels*/
        .carta-info-panel .form-title {
            color: #ffffff;
            text-align: center;
            margin-bottom: 1.25rem;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .carta-info-panel .form-group label {
            color: #cccccc;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Valores estáticos*/
        .carta-info-panel .form-static {
            background: #2a2a2a;
            border: 1px solid #3a3a3a;
            color: #ffffff;
            min-height: 38px;
            padding: 6px 12px;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }

        /* Grade de campos em 2 colunas */
        .carta-info-panel .form-fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .carta-info-panel .form-fields-grid .form-group {
            margin-bottom: 0;
        }

        /* Ações (contador + botão) */
        .carta-info-panel .card-actions {
            margin: 0 0 0.5rem 0;
            gap: 1rem;
            display: flex;
            align-items: center;
        }

        .carta-info-panel .form-footer-link {
            margin-top: 0.5rem;
            color: #aaa;
            text-align: center;
        }

        .carta-info-panel .form-footer-link a {
            color: var(--color-crimson-light);
            text-decoration: none;
            font-weight: 600;
        }

        .carta-info-panel .form-footer-link a:hover {
            text-decoration: underline;
        }

        /* Divisor */
        .carta-info-panel .form-divider {
            background: #3a3a3a;
            height: 1px;
            margin: 1rem 0;
        }

        /*Responvidade*/
        @media (max-width: 780px) {
            .carta-layout {
                flex-direction: column;
                /* empilha verticalmente */
                align-items: center;
                gap: 1.5rem;
            }

            .carta-imagem-box {
                flex: 0 0 auto;
                width: 200px;
                height: 200px;
                /* mantém quadrado */
                max-width: 60%;
            }

            .carta-info-panel {
                flex: 0 0 auto;
                width: 100%;
                max-width: 500px;
                padding: 1.25rem;
            }

            .carta-info-panel .form-fields-grid {
                grid-template-columns: 1fr;
                /* vira uma coluna */
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .carta-imagem-box {
                width: 140px;
                height: 140px;
                max-width: 80%;
            }

            .carta-info-panel {
                padding: 1rem;
            }
        }
        .container-wrap{
            flex: 1;
            padding: 2rem .75rem;
        }
    </style>
</head>

<body>

    <?php
    include("navbar.php");

    // Consulta segura via PDO com parâmetro bindado, usando o id guardado na sessão
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
    <div class="container-wrap mt-4">
        <?php if ($stmt->rowCount() === 0): ?>
            <div class="carta-nao-encontrada">
                <p>Nenhuma carta encontrada.</p>
                <a href="index.php" class="form-footer-link">← Voltar para a lista</a>
            </div>
        <?php else: ?>
            <div class="carta-layout">

                <!-- Imagem da carta (esquerda) -->
                <div class="carta-imagem-box">
                    <img src="img/<?php echo htmlspecialchars($imagem ?? 'SemImagem.png') ?>"
                        alt="<?php echo htmlspecialchars($nome ?? 'Sem nome') ?>">
                </div>

                <!-- Informações da carta (direita) -->
                <div class="carta-info-panel form-wrap">
                    <p class="form-title">Detalhes da carta</p>

                    <div class="form-fields-grid">
                        <div class="form-group">
                            <label>Nome</label>
                            <div class="form-static"><?php echo htmlspecialchars($nome ?? '') ?></div>
                        </div>
                        <div class="form-group">
                            <label>Raridade</label>
                            <div class="form-static"><?php echo htmlspecialchars($raridade ?? '') ?></div>
                        </div>
                        <div class="form-group">
                            <label>Lendário</label>
                            <div class="form-static"><?php echo $lendariotext ? 'Sim' : 'Não' ?></div>
                        </div>
                        <div class="form-group">
                            <label>Sangue</label>
                            <div class="form-static"><?php echo htmlspecialchars($sangue ?? '') ?></div>
                        </div>
                        <div class="form-group">
                            <label>Coleção</label>
                            <div class="form-static"><?php echo htmlspecialchars($colecao ?? '') ?></div>
                        </div>
                        <div class="form-group">
                            <label>Preço</label>
                            <div class="form-static">R$ <?php echo number_format($preco ?? 0, 2, ",", ".") ?></div>
                        </div>
                    </div>
                    
                    <!-- <div class="form-divider"></div>

                    <div class="card-actions">
                        <div class="card-counter">
                            <button class="counter-btn" onclick="changeQty(this, -1)">−</button>
                            <span class="counter-qty">0</span>
                            <button class="counter-btn" onclick="changeQty(this, 1)">+</button>
                        </div>
                        <button class="btn-lista">+Lista</button>
                    </div> -->

                    <div class="form-footer-link mb-3">
                        <a href="index.php">← Voltar para a lista</a>
                    </div>
                    <?php if (isset($_SESSION['nivel']) && $_SESSION['nivel'] === 'adm'): ?>
                        <div class="form-group d-flex justify-content-center align-items-center">
                            <form action="editar.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id_carta" value="<?php echo "" . $id;    ?>">
                                <button type="submit" class="btn-toolbar">
                                    Editar
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        <?php endif; ?>
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