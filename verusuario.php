<!DOCTYPE html>
<html lang="pt-br">
<?php

session_start();?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crimsom Beast</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php include("conexao.php") ?>
    <?php include("navbar.php") ?>
    <a href="logout.php">
        <button type="button">Sair</button>
    </a>

    <?php
    if (isset($_SESSION['nome'])){
        $nomelog = $_SESSION['nome'];
    }
    else {
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

    <main class="page-wrap">

    </main>

</body>

</html>