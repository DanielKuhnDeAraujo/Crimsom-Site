<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Crimsom Beast</title>
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
        nav{
            background-color: var(--bg-secondary);
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
                <img src="img/login.png" alt="Login" width="45" height="45" class="d-inline-block align-itens-end">
                <h7>Login</h7>
            </a>
        </div>
    </nav>

    <div class="page-wrap">
        <?php
        if(isset($_GET['erro'])){
            if ($_GET['erro']=='falta'){
                $erro = "Tivemos um problema, não recebemos todos os dados necessários.";
            }
            if ($_GET['erro']=='nenc'){
                $erro = "Não encontramos nenhum usuário com esse nome ou email.";
            }
            if ($_GET['erro']=='senha'){
                $erro = "Senha Incorreta";
            }
            echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>'. $erro . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }?>
        <div class="page-header">
            <div>
                <h1>Entre na sua conta</h1>
                <p>Acesse sua conta e esteja devolta a melhor e unica loja do menor TCG do Brasil!!</p>
            </div>
        </div>

        <div class="form-wrap" style="margin-top: 2rem;">
            <p class="form-title">Login</p>
            <p class="form-subtitle">Preencha os campos abaixo para acessar sua conta.</p>

            <form action="login_action.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome ou Email</label>
                    <input type="text" id="nome" name="ident" placeholder="Seu nome ou email" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Sua Senha" required minlength="8">
                </div>

                <div class="form-divider"></div>

                <button type="submit" class="form-btn">Entrar</button>

            </form>

            <p class="form-footer-link">
                Não tem uma conta? <a href="cadastro.php">Criar conta</a>
            </p>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 Crimsom Beast. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
<script src="script.js"></script>

</html>