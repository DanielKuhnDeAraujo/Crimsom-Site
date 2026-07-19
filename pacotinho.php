<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacotinho</title>
    <link rel="icon" type="image/x-icon" href="img/logo.ico">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        :root {
            --pct-card-bg: #1a1a1d;
            --pct-border: #2c2c30;
            --pct-ordinario: #d7d7d7;
            --pct-excepcional: #2ecc71;
            --pct-elite: #f39c12;
            --pct-unico: #a569f5;
            --pct-desespero: #ff4c4c;
        }

        .pacotinho-subtitulo {
            color: #9a9aa2;
            font-family: 'Rajdhani', sans-serif;
            letter-spacing: .03em;
            margin-top: -.25rem;
        }

        .pacotinho-arena {
            max-width: 900px;
            margin: 1.5rem auto 0;
            padding: 0 .5rem;
        }

        .pacote-card {
            position: relative;
            background: var(--pct-card-bg);
            border: 1px solid var(--pct-border);
            border-radius: 16px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(16px) scale(.94);
            animation: pacote-revelar .5s cubic-bezier(.2, .8, .2, 1) var(--delay, 0s) forwards;
            transition: box-shadow .25s ease, transform .2s ease;
        }

        .pacote-card:hover {
            transform: translateY(-4px);
        }

        @keyframes pacote-revelar {
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .pacote-card-raridade-tag {
            position: absolute;
            top: .6rem;
            left: .6rem;
            z-index: 2;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            font-size: .68rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .2rem .55rem;
            border-radius: 999px;
            background: rgba(0, 0, 0, .55);
        }

        .pacote-card-imagem {
            position: relative;
            aspect-ratio: 3 / 4;
            overflow: hidden;
            background: #0e0e10;
        }

        .pacote-card-imagem img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .pacote-card-brilho {
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, transparent 40%, rgba(255, 255, 255, .35) 50%, transparent 60%);
            transform: translateX(-120%);
            pointer-events: none;
        }

        .pacote-card:hover .pacote-card-brilho {
            animation: pacote-brilho-varre .9s ease;
        }

        @keyframes pacote-brilho-varre {
            to { transform: translateX(120%); }
        }

        .pacote-card-rodape {
            padding: .65rem .8rem .8rem;
            border-top: 1px solid var(--pct-border);
        }

        .pacote-card-nome {
            margin: 0;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 600;
            font-size: .95rem;
            color: #fff;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Variações por raridade (mesma paleta que você já usava) */
        .raridade-ordinario { border-color: rgba(215, 215, 215, .25); }
        .raridade-ordinario .pacote-card-raridade-tag { color: var(--pct-ordinario); border: 1px solid rgba(215, 215, 215, .4); }

        .raridade-excepcional { border-color: rgba(46, 204, 113, .4); }
        .raridade-excepcional:hover { box-shadow: 0 0 18px rgba(46, 204, 113, .25); }
        .raridade-excepcional .pacote-card-raridade-tag { color: var(--pct-excepcional); border: 1px solid rgba(46, 204, 113, .5); }

        .raridade-elite { border-color: rgba(243, 156, 18, .45); }
        .raridade-elite:hover { box-shadow: 0 0 20px rgba(243, 156, 18, .3); }
        .raridade-elite .pacote-card-raridade-tag { color: var(--pct-elite); border: 1px solid rgba(243, 156, 18, .5); }

        .raridade-unico { border-color: rgba(165, 105, 245, .5); box-shadow: 0 0 14px rgba(165, 105, 245, .15); }
        .raridade-unico:hover { box-shadow: 0 0 26px rgba(165, 105, 245, .4); }
        .raridade-unico .pacote-card-raridade-tag { color: var(--pct-unico); border: 1px solid rgba(165, 105, 245, .5); }

        .raridade-desespero {
            border-color: var(--pct-desespero);
            box-shadow: 0 0 20px rgba(255, 76, 76, .3);
            animation: pacote-revelar .5s cubic-bezier(.2, .8, .2, 1) var(--delay, 0s) forwards,
                       pacote-pulso-desespero 1.8s ease-in-out 1s infinite;
        }
        .raridade-desespero:hover { box-shadow: 0 0 32px rgba(255, 76, 76, .55); }
        .raridade-desespero .pacote-card-raridade-tag { color: #fff; background: rgba(255, 76, 76, .85); }

        @keyframes pacote-pulso-desespero {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 76, 76, .3); }
            50% { box-shadow: 0 0 32px rgba(255, 76, 76, .55); }
        }

        .btn-pacotinho {
            background: linear-gradient(135deg, #2c2c30, #1a1a1d);
            border: 1px solid var(--pct-border);
            color: #fff;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 600;
            letter-spacing: .03em;
            padding: .6rem 1.4rem;
            border-radius: 10px;
            transition: border-color .2s ease, transform .2s ease;
        }

        .btn-pacotinho:hover {
            color: #fff;
            border-color: var(--pct-unico);
            transform: translateY(-2px);
        }

        @media (prefers-reduced-motion: reduce) {
            .pacote-card, .raridade-desespero {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
            .pacote-card-brilho { display: none; }
        }
    </style>
</head>

<body>
    <?php
    include("navbar.php");
    include("conexao.php");

    // Ordinários   50% (1-50)
    // Excepcionais 30% (51-80)
    // Elite        13% (81-93)
    // Único         5% (94-98)
    // Desespero     2% (99-100)

    // Ajuste esta pasta para onde as imagens das cartas (coluna IMAGEM) estão salvas
    $pastaImagens = "img/";

    $cartasSelecionadas = [];
    $jaforam = array_fill(0, 9, '');
    $i = 1;
    while ($i <= 9) {
        $rand = rand(1, 100);
        $raridade = "";
        if ($rand <= 100) $raridade = "desespero";
        if ($rand <= 98)  $raridade = "unico";
        if ($rand <= 93)  $raridade = "elite";
        if ($rand <= 80)  $raridade = "excepcional";
        if ($rand <= 50)  $raridade = "ordinario";
        
        $stmt = $conn->prepare('SELECT * FROM cartas WHERE raridade LIKE :raridade');
        $stmt->bindValue(':raridade', '%' . $raridade . '%', PDO::PARAM_STR);
        $stmt->execute();
        $cartas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($raridade == "ordinario") {
            $stmt = $conn->prepare('SELECT * FROM cartas WHERE raridade LIKE "ordinario" or raridade like "sacrificio" ');
            $stmt->execute();
            $cartas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if (empty($cartas)) {
            // nenhuma carta cadastrada nessa raridade ainda, sorteia de novo
            continue;
        }

        $cartaAleatoria = $cartas[array_rand($cartas)];

        if (in_array($cartaAleatoria["ID_CARTA"], $jaforam)) {
            continue;
        }

        $jaforam[$i - 1] = $cartaAleatoria["ID_CARTA"];
        $cartaAleatoria["RARIDADE_SORTEADA"] = $raridade;
        $cartasSelecionadas[] = $cartaAleatoria;
        $i++;
    }
    ?>

    <div class="page-wrap">
        <div class="page-header">
            <div>
                <h1>Simulador de Pacotinho!</h1>
                <p class="pacotinho-subtitulo">9 cartas por pacote — role para revelar sua sorte.</p>
            </div>
        </div>

        <div class="pacotinho-arena">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
                <?php foreach ($cartasSelecionadas as $index => $carta):
                    $raridade = $carta["RARIDADE_SORTEADA"];
                    $delay = $index * 0.08;
                ?>
                    <div class="col">
                        <div class="pacote-card raridade-<?= $raridade ?>" style="--delay: <?= $delay ?>s;">
                            <span class="pacote-card-raridade-tag"><?= htmlspecialchars(ucfirst($raridade)) ?></span>
                            <div class="pacote-card-imagem">
                                <img src="img/<?php echo $carta['IMAGEM'] ;?>"
                                     alt="<?= htmlspecialchars($carta['NOME']) ?>"
                                     >
                                <span class="pacote-card-brilho"></span>
                            </div>
                            <div class="pacote-card-rodape">
                                <p class="pacote-card-nome"><?= htmlspecialchars($carta['NOME']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="text-center">
            <a class="btn btn-pacotinho mt-4" href="pacotinho.php">↻ Abrir outro pacotinho</a>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 Crimsom Beast. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>