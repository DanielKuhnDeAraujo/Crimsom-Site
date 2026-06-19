<!DOCTYPE html>
<html lang="en">
 <?php include("conexao.php")?>
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
    <div class="page-wrap">
        <div class="page-header">
            <div>
                <h1 class="">Bem-vindo ao Crimsom Beast!</h1>
                <p>Jogue, compre cartas e divirta-se com o menor TCG brasileiro!</p>
            </div>
        </div>
    </div>

    <div class="card-grid">

        <?php
        $stmt = $conn->prepare('SELECT * FROM cartas');
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="card-wrap">
                    <div class="card-header-bar">
                        <span class="card-name"><?= htmlspecialchars($row['NOME']) ?></span>
                        <span class="badge-rarity rarity-<?= htmlspecialchars($row['RARIDADE']) ?>"><?= htmlspecialchars($row['RARIDADE']) ?></span>
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

        <div class="card-wrap">
            <div class="card-header-bar">
                <span class="card-name">Sapo Gigante</span>
                <span class="badge-rarity">Ordinário</span>
            </div>
            <div class="card-art">
                <a href="#" class="card-art-link">
                    <img src="img/logo.png" alt="Sapo Gigante">
                </a>
            </div>
            <div class="card-footer-bar">
                <span class="card-edition">Coleção:</span>
                <span class="card-price">R$ 12,90</span>
            </div>
            <div clss="card-actions">
                <div class="card-counter">
                    <button class="counter-btn" onclick="changeQty(this, -1)">−</button>
                    <span class="counter-qty">0</span>
                    <button class="counter-btn" onclick="changeQty(this, 1)">+</button>
                </div>
                <button class="btn-lista">+Lista</button>
            </div>
        </div>

        <div class="card-wrap">
            <div class="card-header-bar">
                <span class="card-name">Sapo Gigante+</span>
                <span class="badge-rarity rarity-rare">Excepcional</span>
            </div>
            <div class="card-art">
                <a href="#" class="card-art-link">
                    <img src="img/logo.png" alt="Sapo Gigante+">
                </a>
            </div>
            <div class="card-footer-bar">
                <span class="card-edition">Coleção:</span>
                <span class="card-price">R$ 89,90</span>
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

        <div class="card-wrap">
            <div class="card-header-bar">
                <span class="card-name">Sapo Gigante+++</span>
                <span class="badge-rarity rarity-legendary">Elite</span>
            </div>
            <div class="card-art">
                <a href="#" class="card-art-link">
                    <img src="img/logo.png" alt="Sapo Gigante+++">
                </a>
            </div>
            <div class="card-footer-bar">
                <span class="card-edition">Coleção:</span>
                <span class="card-price">R$ 199,90</span>
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

        <div class="card-wrap">
            <div class="card-header-bar">
                <span class="card-name">Sapo Gigante++++</span>
                <span class="badge-rarity rarity-unique">Único</span>
            </div>
            <div class="card-art">
                <a href="#" class="card-art-link">
                    <img src="img/logo.png" alt="Sapo Gigante++++">
                </a>
            </div>
            <div class="card-footer-bar">
                <span class="card-edition">Coleção:</span>
                <span class="card-price">R$ 349,90</span>
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
    <footer>
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