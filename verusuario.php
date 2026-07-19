<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start(); 
if (isset($_SESSION['nome'])) {
        $nomelog = $_SESSION['nome'];
    } else {
        header("Location:login.php");
        exit;
    }?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crimsom Beast</title>
    <link rel="icon" type="image/x-icon" href="img/logo.ico">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .page-header {
            margin-left: -1rem;
            gap: 1;
        }

        .toolbar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .search-form {
            justify-content: center;
            align-items: center;
            padding: 1rem;
            margin-bottom: 0;
        }

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
            flex: 2 1 280px;
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

        .container-wrap {
            flex: 1;
            padding: 2rem .75rem;
        }
    </style>
</head>

<body>
    <?php include("conexao.php") ?>
    <?php include("navbar.php") ?>

    <?php
    
    try {
        $sql = " SELECT * FROM usuario WHERE nome = :nome ";
        $query = $conn->prepare($sql);
        $query->bindValue(':nome', $nomelog, PDO::PARAM_STR);
        $query->execute();

        if ($dados = $query->fetch(PDO::FETCH_ASSOC)) {
            $NOME = $dados["NOME"];
            $EMAIL = $dados["EMAIL"];
            $SENHA = $dados["SENHA"];
            $NIVEL = $dados["NIVEL"];
        } else {
            throw new Exception("O perfil de nome ". $nomelog. " não foi encontrado");
        }

    } catch (Exception $e) {
        echo "<main class='container' style='padding-top:40px'>
                <div class='alert alert-danger'>{$e->getMessage()}</div>
                <a href='index.php' class='btn btn-primary'>Voltar</a>
              </main>";
        exit;
    }

    ?>


    <?php

    $msg_sucesso = null;
    $msg_erro_email = null;
    $msg_erro_senha = null;

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'trocar_email') {
            $novo_email = trim($_POST['novo_email'] ?? '');

            if (!filter_var($novo_email, FILTER_VALIDATE_EMAIL)) {
                $msg_erro_email = "Digite um email válido.";
            } else {

                $sql = "UPDATE usuario SET EMAIL = :email WHERE nome = :nome";
                $upd = $conn->prepare($sql);
                $upd->execute(['email' => $novo_email, 'nome' => $nomelog]);
                $msg_sucesso = "Email atualizado com sucesso!";

            }
        }
    } catch (Exception $e) {
        echo "<main class='container' style='padding-top:40px'>
                <div class='alert alert-danger'>{$e->getMessage()}</div>
                <p>Erro em atualizar email</p>
                <a href='index.php' class='btn btn-primary'>Voltar</a>
              </main>";
        exit;
    }

    ?>

    <?php

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'trocar_senha') {

            $senha_atual = $_POST['senha_atual'] ?? '';
            $nova_senha = $_POST['nova_senha'] ?? '';
            $confirmar = $_POST['confirmar_senha'] ?? '';


            if ($nova_senha !== $confirmar) {
                $msg_erro_senha = "As senhas novas não coincidem.";

            } elseif (strlen($nova_senha) < 6) {

                $msg_erro_senha = "A nova senha deve ter pelo menos 6 caracteres.";

            } else {

                $sql = "SELECT SENHA FROM usuario WHERE nome = :nome";
                $check = $conn->prepare($sql);
                $check->execute(['nome' => $nomelog]);
                $hashAtual = $check->fetchColumn();

                if (!$hashAtual || !password_verify($senha_atual, $hashAtual)) {

                    $msg_erro_senha = "Senha atual incorreta.";

                } else {

                    $novoHash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    $sql = "UPDATE usuario SET SENHA = :senha WHERE nome = :nome";
                    $upd = $conn->prepare($sql);
                    $upd->execute(['senha' => $novoHash, 'nome' => $nomelog]);
                    $msg_sucesso = "Senha atualizada com sucesso!";

                }
            }
        }

    } catch (Exception $e) {

        echo "<main class='container' style='padding-top:40px'>
                <div class='alert alert-danger'>{$e->getMessage()}</div>
                <p>Erro em atualizar senha</p>
                <a href='index.php' class='btn btn-primary'>Voltar</a>
              </main>";
        exit;

    }

    ?>

    <div class="container-wrap">
        <div class="page-header">
            <h1>Meu Perfil</h1>
        </div>

        <div class="toolbar">
            <form class="search-form">
                <a class="btn-toolbar" href="index.php">Voltar a loja</a>
                <a class="btn-toolbar" href="logout.php">Sair</a>
            </form>
        </div>
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php else: ?>
            <div class="carta-layout">
                <!-- Informações da carta (direita) -->
                <div class="carta-info-panel form-wrap">
                    <h5 class="form-title"> <?= htmlspecialchars($NOME) ?>
                        <span class="badge bg-secondary"><?= htmlspecialchars($NIVEL) ?></span>
                    </h5>

                    <div class="perfil-campos" style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                        <table class="mb-3 mt-3">
                            <tr class="">
                                <th class="text-white p-md-2">Nome:</th>
                                <td class="text-white">
                                    <?= htmlspecialchars($NOME) ?>
                                </td>
                            </tr>
                            <tr >
                                <th class="text-white p-md-2">Email:</th>
                                <td class="text-white">
                                    <?= htmlspecialchars($EMAIL) ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-white p-md-2">Nível:</th>
                                <td class="text-white">
                                    <?= htmlspecialchars($NIVEL) ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-divider"></div>

                    <!-- Botões lado a lado -->
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modalEmail">Mudar email</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modalSenha">Mudar senha</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </div>


    <div class="modal fade" id="modalEmail" tabindex="-1" aria-labelledby="modalEmailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="verusuario.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEmailLabel">Mudar email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($msg_erro_email): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($msg_erro_email) ?></div>
                    <?php endif; ?>

                    <input type="hidden" name="acao" value="trocar_email">

                    <div class="mb-3">
                        <label for="novo_email" class="form-label">Novo email</label>
                        <input type="email" class="form-control" id="novo_email" name="novo_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalSenha" tabindex="-1" aria-labelledby="modalSenhaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="verusuario.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSenhaLabel">Mudar senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($msg_erro_senha): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($msg_erro_senha) ?></div>
                    <?php endif; ?>

                    <input type="hidden" name="acao" value="trocar_senha">

                    <div class="mb-3">
                        <label for="senha_atual" class="form-label">Senha atual</label>
                        <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                    </div>
                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova senha</label>
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" minlength="6"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar nova senha</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha"
                            minlength="6" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="">
        <div class="container-fluid">
            <p>&copy; 2026 Crimsom Beast. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="js/bootstrap.bundle.min.js"></script>
    
</body>

</html>