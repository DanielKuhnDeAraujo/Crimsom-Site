<!DOCTYPE html>
<html lang="pt-br">
<?php

session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crimsom Beast</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>

    </style>
</head>

<body>
    <?php include("conexao.php") ?>
    <?php include("navbar.php") ?>

    <?php
    if (isset($_SESSION['nome'])) {
        $nomelog = $_SESSION['nome'];
    } else {
        header("Location:login.php");
    }
    try {
        $sql = "SELECT * FROM usuario WHERE nome = :nome";
        $query = $conn->prepare($sql);
        $query->execute(['nome' => $nomelog]);

        if ($dados = $query->fetch(PDO::FETCH_ASSOC)) {
            $NOME = $dados["NOME"];
            $EMAIL = $dados["EMAIL"];
            $SENHA = $dados["SENHA"];
            $NIVEL = $dados["NIVEL"];
        } else {
            throw new Exception("O seu perfil não foi encontrado");
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

    <div class="page-wrap">
        <div class="page-header">
            <h1>Meu Perfil</h1>
        </div>

        <div class="toolbar">
            <form action="#" method="post" class="search-form">
                <a class="btn-toolbar" href="index.php">Voltar a loja</a>
                <a class="btn-toolbar" href="logout.php">Sair</a>
            </form>
        </div>
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php else: ?>
            <h5 class="card-title"><?= htmlspecialchars($NOME) ?></h5>
            <span class="badge bg-secondary mb-3"><?= htmlspecialchars($NIVEL) ?></span>
            <table class="mb-3 mt-3">
                <tr>
                    <th>Nome:</th>
                    <td><?= htmlspecialchars($NOME) ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?= htmlspecialchars($EMAIL) ?></td>
                </tr>
                <tr>
                    <th>Nível:</th>
                    <td><?= htmlspecialchars($NIVEL) ?></td>
                </tr>
            </table>

        <?php endif; ?>


        <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#modalEmail">Mudar
            email</button>

        <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#modalSenha">Mudar
            senha</button>
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
        <div class="container ">
            <p>&copy; 2026 Crimsom Beast. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>