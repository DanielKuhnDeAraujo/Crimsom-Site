<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crimsom Beast</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php include("conexao.php") ?>

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

    <?php

    try {
        $sql = "SELECT * FROM usuario WHERE id = $id";
        $query = $conn->query($sql);

        if ($query->num_rows > 0) {
            $dados = $query->fetch();
            $NOME = $dados["NOME"];
            $EMAIL = $dados["EMAIL"];
            $SENHA = $dados["SENHA"];
            $NIVEL = $dados["NIVEL"];
        } else {
            throw new Exception("O seu perfil não foi encontrado");
        }

    }catch (Exception $e ){
        echo "<main class='container' style='padding-top:40px'>
                <div class='alert alert-danger'>{$e->getMessage()}</div>
                <a href='index.php' class='btn btn-primary'>Voltar</a>
              </main>";
        exit;
    }

    ?>

    <main class="container">
        
    </main>
</body>

</html>