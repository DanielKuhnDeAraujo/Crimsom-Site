<!DOCTYPE html>
<html lang="pt-BR">
<?php
session_start();
if (isset($_SESSION['nome'])){
    header('Location:index.php');
    exit;
    }?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro — Crimsom Beast</title>
    <link rel="icon" type="image/x-icon" href="img/logo.ico">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: var(--bg-white);
            padding-top: 70px;
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

   <?php
    include("navbar.php")?>

    <div class="page-wrap">
        <?php
        if(isset($_GET['erro'])){
            if ($_GET['erro']=='falta'){
                $erro = "Tivemos um problema, não recebemos todos os dados necessários.";
            }
            if ($_GET['erro']=='repnome'){
                $erro = "Já existe um usuário com esse nome";
            }
            if ($_GET['erro']=='repemail'){
                $erro = "Já existe um usuário com esse email";
            }
            echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>'. $erro . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
        ?>

        <div class="page-header">
            <div>
                <h1>Crie sua conta</h1>
                <p>Junte-se ao menor TCG brasileiro e comece a colecionar!</p>
            </div>
        </div>

        <div class="form-wrap" style="margin-top: 2rem;">
            <p class="form-title">Cadastro</p>
            <p class="form-subtitle">Preencha os campos abaixo para criar sua conta.</p>

            <form action="cadastro_action.php" method="POST">

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="seu@email.com" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Sua senha" required minlength="8">
                </div>

                <div class="form-divider"></div>

                <button type="submit" class="form-btn">Criar conta</button>

            </form>

            <p class="form-footer-link">
                Já tem uma conta? <a href="login.php">Entrar</a>
            </p>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 Crimsom Beast. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>

</html>