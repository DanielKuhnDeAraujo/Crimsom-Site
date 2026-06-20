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
    <?php include("navbar.php") ?>
    <?php

    try {
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute(['id' => $id]);

        if ($query->num_rows > 0) {
            $dados = $query->fetch(PDO::FETCH_ASSOC);
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