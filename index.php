<!DOCTYPE html>
<html lang="en">
<?php include("conexao.php");
session_start(); ?>

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
    </style>
</head>

<body>

    <?php include("navbar.php"); ?>
    <div class="page-wrap">
        <div class="page-header">
            <div>
                <h1 class="">Bem-vindo ao Crimsom Beast!</h1>
                <p>Jogue, compre cartas e divirta-se com o menor TCG brasileiro!</p>
            </div>
        </div>

        <div class="toolbar">
            <form action="#" method="post" class="search-form">
                <div class="search-wrap">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    <input type="search" name="filtro" maxlength="50" placeholder="Buscar por nome…"
                        value="<?php echo isset($_POST['filtro']) ? htmlspecialchars($_POST['filtro']) : ''; ?>">
                </div>
                <button type="submit" class="btn-toolbar">Pesquisar</button>
            </form>
            <?php if (isset($_SESSION['usuario_nivel']) && $_SESSION['usuario_nivel'] == 2): ?>
                <a href="cartas_add.php" class="btn-toolbar">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Adicionar Carta
                </a>
            <?php endif; ?>

        </div>

        <div class="card-grid">
            <?php
            // Monta o SELECT com ou sem filtro de busca, usando parâmetros bindados (PDO)
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filtro']) && trim($_POST['filtro']) !== '') {
                $filtro = trim($_POST['filtro']);
                $stmt = $conn->prepare('SELECT * FROM cartas WHERE nome LIKE :filtro ORDER BY nome');
                $stmt->bindValue(':filtro', '%' . $filtro . '%', PDO::PARAM_STR);
            } else {
                $stmt = $conn->prepare('SELECT * FROM cartas ORDER BY nome');
            }
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                echo '<p>Nenhuma carta encontrada.</p>';
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="card-wrap">
                    <div class="card-header-bar">
                        <span class="card-name"><?= htmlspecialchars($row['NOME']) ?></span>
                        <span
                            class="badge-rarity rarity-<?= htmlspecialchars($row['RARIDADE']) ?>"><?= htmlspecialchars($row['RARIDADE']) ?></span>
                    </div>
                    <div class="card-art">
                        <a href="#" class="card-art-link">
                            <img src="img/logo.png" alt="Sapo Gigante+">
                        </a>
                    </div>
                    <div class="card-footer-bar">
                        <span class="card-edition">Coleção: <?= htmlspecialchars($row['COLECAO']) ?></span>
                        <span class="card-price">R$: <?= htmlspecialchars($row['PRECO']) ?></span>
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
                <?php
            }
            ?>

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