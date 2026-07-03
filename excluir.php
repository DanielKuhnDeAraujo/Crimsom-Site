
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Card</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        /* Layout principal: preview à esquerda, form à direita */
        .cadastro-wrap {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
            max-width: 900px;
            margin: 0 auto;
        }

        /* === ESQUERDA — Preview do card === */
        .preview-side {
            flex-shrink: 0;
            width: 220px;
            position: sticky;
            top: 80px;
        }

        .preview-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--text-muted-light);
            margin-bottom: .75rem;
        }

        .card-preview {
            width: 100%;
            border-radius: 14px;
            border: 1.5px solid var(--color-crimson-dark);
            background: var(--bg-card);
            overflow: hidden;
        }

        .card-preview-header {
            background: linear-gradient(180deg, #1a0a0d, #120608);
            padding: 10px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 6px;
            border-bottom: 1px solid #2a1f1f;
        }

        .card-preview-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--card-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-preview-badge {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 999px;
            white-space: nowrap;
            flex-shrink: 0;
            background: #555;
            color: #fff;
        }

        .badge-ordinario {
            background: #8f8f8f;
            color: #000;
        }

        .badge-excepcional {
            background: var(--color-crimson);
            color: #fff;
        }

        .badge-elite {
            background: #7df481;
            color: #1a1000;
        }

        .badge-legendary {
            background: #c9983a;
            color: #1a1000;
        }

        .badge-unico {
            background: #5b0085;
            color: #f0e0ff;
        }

        .card-preview-art {
            height: 200px;
            background: #0d0305;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .card-preview-art img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .card-preview-art img.visible {
            display: block;
        }

        .upload-hint {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            pointer-events: none;
            transition: opacity .2s;
        }

        .upload-hint svg {
            color: #333;
        }

        .upload-hint span {
            font-size: 11px;
            color: #444;
            text-align: center;
        }

        .card-preview-art.has-image .upload-hint {
            opacity: 0;
        }

        .card-preview-art.has-image:hover .upload-hint {
            opacity: 1;
            position: relative;
            z-index: 2;
        }

        .card-preview-art.has-image:hover::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .5);
        }

        .card-preview-art.has-image:hover .upload-hint svg,
        .card-preview-art.has-image:hover .upload-hint span {
            color: #fff;
        }

        .card-preview-footer {
            background: #100508;
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #2a1f1f;
        }

        .card-preview-collection {
            font-size: 11px;
            color: var(--card-text);
            font-weight: 600;
        }

        .card-preview-price {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-crimson-light);
        }

        #imagem {
            display: none;
        }

        /* === DIREITA — Formulário === */
        .form-side {
            flex: 1;
            min-width: 0;
        }

        .form-wrap {
            max-width: 100%;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 500px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group select {
            width: 100%;
            background-color: #100508;
            border: 1px solid #2a1f1f;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: var(--card-text);
            outline: none;
            cursor: pointer;
            transition: border-color .2s;
        }

        .form-group select:focus {
            border-color: var(--color-crimson);
        }

        .form-group select option {
            background: #1c1c1c;
            color: var(--card-text);
        }

        input[type="radio"] {
            accent-color: var(--color-crimson);
        }

        .input-prefix-wrap {
            display: flex;
            align-items: stretch;
            background: #100508;
            border: 1px solid #2a1f1f;
            border-radius: 8px;
            overflow: hidden;
            transition: border-color .2s;
        }

        .input-prefix-wrap:focus-within {
            border-color: var(--color-crimson);
        }

        .input-prefix {
            padding: 0 10px;
            font-size: 13px;
            font-weight: 700;
            color: var(--color-crimson-light);
            background: #0c0306;
            border-right: 1px solid #2a1f1f;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .input-prefix-wrap input {
            border: none;
            border-radius: 0;
            background: transparent;
            padding: 10px 12px;
            font-size: 14px;
            color: var(--card-text);
            outline: none;
            flex: 1;
            min-width: 0;
        }

        .input-prefix-wrap input::placeholder {
            color: var(--text-muted);
        }

        /* Responsivo */
        @media (max-width: 680px) {
            .cadastro-wrap {
                flex-direction: column;
            }

            .preview-side {
                width: 100%;
                position: static;
            }

            .card-preview {
                max-width: 260px;
                margin: 0 auto;
            }
        }

        /* Estilos para as mensagens */
        .alert-custom {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            background: #1a1a1a;
            border-left: 4px solid;
        }

        .alert-success-custom {
            border-color: #2e7d32;
            color: #b9f6ca;
        }

        .alert-danger-custom {
            border-color: #c62828;
            color: #ffcdd2;
        }

        .alert-custom a {
            color: inherit;
            text-decoration: underline;
        }

        .btn-teal {
            display: inline-block;
            background: #00897b;
            color: #fff;
            padding: 0.3rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-outline {
            display: inline-block;
            border: 1px solid #888;
            color: #ccc;
            padding: 0.3rem 1rem;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <main class="page-wrap">

        <div style="height:1.75rem"></div>

        <!-- Exibição da mensagem (se existir) -->
        <?php
            try{
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
                    include "conexao.php";
                    $id = $_POST['id'];
                    
                    $stmt = $conn->prepare("DELETE FROM cartas WHERE id_carta = ?");
                    $stmt->bindValue(1, $id, PDO::PARAM_INT);
                    $stmt->execute();
                    echo "sucesso! apagou a carta cujo id é $id";
                }
            }
            catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        ?>

        <div class="d-flex justify-content-center mt-4">
            <a href="index.php" class="btn btn-danger">Voltar</a>
        </div>
    </main>

    <footer>
        <p>© 2026 Crimsom Beast. Todos os direitos reservados.</p>
    </footer>

    <script>
        const rarityMap = {
            ordinario: { label: 'Ordinário', cls: 'badge-ordinario' },
            excepcional: { label: 'Excepcional', cls: 'badge-excepcional' },
            elite: { label: 'Elite', cls: 'badge-elite' },
            legendary: { label: 'Lendário', cls: 'badge-legendary' },
            unico: { label: 'Único', cls: 'badge-unico' },
        };

        function updatePreview() {
            const nome = document.getElementById('nome').value.trim();
            document.getElementById('prevNome').textContent = nome || 'Nome do card';

            const rarVal = document.getElementById('raridade').value;
            const badge = document.getElementById('prevBadge');
            badge.className = 'card-preview-badge';
            if (rarVal && rarityMap[rarVal]) {
                badge.textContent = rarityMap[rarVal].label;
                badge.classList.add(rarityMap[rarVal].cls);
            } else {
                badge.textContent = '—';
            }

            const col = document.getElementById('colecao').value.trim();
            document.getElementById('prevColecao').textContent = col || '—';

            const preco = document.getElementById('preco').value;
            document.getElementById('prevPreco').textContent = preco
                ? 'R$ ' + parseFloat(preco).toFixed(2)
                : '—';
        }

        document.getElementById('imagem').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById('prevImg');
                const art = document.getElementById('previewArt');
                img.src = e.target.result;
                img.classList.add('visible');
                art.classList.add('has-image');
            };
            reader.readAsDataURL(file);
        });

        ['nome', 'colecao', 'preco', 'raridade'].forEach(id => {
            const el = document.getElementById(id);
            el.addEventListener('input', updatePreview);
            el.addEventListener('change', updatePreview);
        });
    </script>
</body>

</html>