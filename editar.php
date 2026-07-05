<?php
session_start();
include "conexao.php";
// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    try {
        if(!empty($_POST["id_carta"])){
            $id =   (int) ($_POST['id_carta']);
            if(!empty($_POST['update'])){
            
            // Captura e sanitização
            $nome = trim($_POST['nome'] ?? '');
            $id2 = (int) ($_POST['id2'] ?? 0);
            $sangue = trim($_POST['sangue'] ?? '');
            $preco = (float) str_replace(',', '.', $_POST['preco'] ?? 0);
            $raridade = $_POST['raridade'] ?? '';
            $lendario = isset($_POST['lendario']) && $_POST['lendario'] === 's' ? 's' : 'n';
            $colecao = trim($_POST['colecao'] ?? '');
            if (empty($id2)){
                $id2 = $id;
            }

            // Validações
            if (empty($nome) || empty($raridade) || empty($colecao)) {
                throw new Exception("Nome, raridade e coleção são obrigatórios.");
            }
            if ($preco < 0) {
                throw new Exception("Preço não pode ser negativo.");
            }
            $imagem = $_POST['imagem'];
            $arquivo = $imagem; // mantém a imagem atual

            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                unlink("img/" . $arquivo);

                $extensoes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

                if (!in_array($ext, $extensoes)) {
                    throw new Exception("Extensão não permitida.");
                }

                $arquivo = uniqid('card_', true) . '.' . $ext;
                $destino = "img/" . $arquivo;

                if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                    throw new Exception("Erro ao salvar a imagem.");
                }
            }

            // Inserção no banco (com prepared statement)
            $sql = "update cartas set NOME = ?, IMAGEM=?, SANGUE=?, RARIDADE=?, LENDARIO=?, COLECAO=?, ID2=?, PRECO=? where ID_CARTA=?";
            $stmt = $conn->prepare($sql);
            if (!$stmt->execute([$nome, $arquivo, $sangue, $raridade, $lendario, $colecao, $id2, $preco,$id])) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Erro ao editar: " . ($errorInfo[2] ?? 'Falha na execução'));
            }
            $stmt = null;

            $mensagem = '
            <div class="alert-custom alert-success-custom">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <div>
                    <strong>Editado com sucesso!</strong><br>
                    <a href="index.php" class="btn-teal" style="margin-top:.6rem;">Voltar à listagem</a>
                </div>
            </div>';

    }
        $stmt = $conn->prepare('SELECT * FROM cartas WHERE id_carta LIKE :id ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nome = $row['NOME'];
        $id2 = $row['ID2'];
        $sangue = $row['SANGUE'];
        $preco = $row['PRECO'];
        $raridade = $row['RARIDADE'];
        $lendario = $row['LENDARIO'];
        $colecao = $row['COLECAO'];
        if (empty($id2)){
            $id2 = $id;
        }
        $imagem = $row['IMAGEM'];
    }else{
        throw new Exception("Id da carta não foi encontrado.");
    }
    } catch (Exception $e) {
        $mensagem = '
        <div class="alert-custom alert-danger-custom">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong>Erro:</strong> ' . htmlspecialchars($e->getMessage()) . '<br>
                <a href="index.php" class="btn-outline" style="margin-top:.6rem;">Voltar</a>
            </div>
        </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Card</title>
    <link rel="icon" type="image/x-icon" href="img/logo.ico">
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
        include "navbar.php";
        if (isset($mensagem))
            echo $mensagem; ?>

        <div class="cadastro-wrap">

            <!-- ESQUERDA: preview -->
            <div class="preview-side">
                <p class="preview-label">Preview do Card</p>
                <div class="card-preview">

                    <div class="card-preview-header">   
                        <span class="card-preview-name" id="prevNome"><?php echo $nome;?></span>
                        <span class="card-preview-badge" id="prevBadge"><?php echo $raridade;?></span>
                    </div>

                    <div class="card-preview-art <?php echo !empty($imagem) ? 'has-image' : ''; ?>" id="previewArt" onclick="document.getElementById('imagem').click()">
                        <img
                            id="prevImg"
                            src="<?php echo !empty($imagem) ? 'img/' . htmlspecialchars($imagem) : ''; ?>"
                            alt="Arte do card"
                            class="<?php echo !empty($imagem) ? 'visible' : ''; ?>"
                        >

                        <div class="upload-hint">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <span>Clique para<br>adicionar imagem</span>
                        </div>
                    </div>

                    <div class="card-preview-footer">
                        <span class="card-preview-collection" id="prevColecao"><?php echo $colecao;?></span>
                        <span class="card-preview-price" id="prevPreco"><?php echo $preco;?></span>
                    </div>

                </div>
            </div>

            <!-- DIREITA: formulário -->
            <div class="form-side">
                <div class="form-wrap">
                    <p class="form-title mb-5">Editar carta</p>

                    <form action="editar.php" method="POST" enctype="multipart/form-data">

                        <input type="file" id="imagem" name="imagem" accept="image/*">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" name="nome" value="<?php echo $nome;?>" placeholder="Nome da carta" required>
                            </div>
                            <div class="form-group">
                                <label for="id2">ID Secundário</label>
                                <input type="number" id="id2" name="id2" value="<?php echo $id2;?>" min="0" placeholder="ex: 0042">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="sangue">Sangue</label>
                                <input type="number" id="sangue" name="sangue"  value="<?php echo $sangue;?>"min="0" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label for="preco">Preço</label>
                                <div class="input-prefix-wrap">
                                    <span class="input-prefix">R$</span>
                                    <input type="number" id="preco" name="preco" value="<?php echo $preco;?>" min="0" step="0.01" placeholder="0,00">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="raridade">Raridade</label>
                                <select id="raridade" name="raridade" required>
                                    <option value="" disabled >Selecionar...</option>
                                    <option value="ordinario" <?php if($raridade=="ordinario"){echo "selected";}?>>Ordinário</option>
                                    <option value="excepcional" <?php if($raridade=="excepcional"){echo "selected";}?>>Excepcional</option>
                                    <option value="elite" <?php if($raridade=="elite"){echo "selected";}?>>Elite</option>
                                    <option value="unico" <?php if($raridade=="unico"){echo "selected";}?>>Único</option>
                                    <option value="sacrificio" <?php if($raridade=="sacrificio"){echo "selected";}?>>Sacrifício</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lendário</label>
                                <div style="display:flex; gap:1rem; padding:10px 0;">
                                    <label style="color:var(--card-text); font-size:14px;">
                                        <input type="radio" name="lendario" value="s" <?php if($lendario=="s"){echo "checked";}?>> Sim
                                    </label>
                                    <label style="color:var(--card-text); font-size:14px;">
                                        <input type="radio" name="lendario" value="n" <?php if($lendario=="n"){echo "checked";}?>> Não
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="colecao">Coleção</label>
                            <input type="text" id="colecao" name="colecao" value="<?php echo $colecao;?>" placeholder="Nome da coleção" required>
                        </div>

                        <div class="form-divider"></div>

                        <input type="hidden" name="id_carta" value="<?php echo $id?>">
                        <input type="hidden" name="imagem" value="<?php echo $imagem?>">     
                        <input type="hidden" name="update" value="true">                        
                        <button type="submit" class="form-btn">Salvar mudanças</button>

                        <div class="form-footer-link">
                            <a href="index.php">← Voltar para a lista</a>
                        </div>

                    </form>
                </div>
            </div>

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