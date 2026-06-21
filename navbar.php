<?php 
$logado = false;
if(isset($_SESSION['nome'])){
    $logado= true;
    $nome = $_SESSION['nome'];
} ?>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="ms-2 navbar-brand" href="index.php">
                <img src="img/logo.png" alt="Logo" width="60" height="50" class="d-inline-block align-itens-end">
                <b>Crimsom Beasts</b>
            </a>
            <a class="navbar-brand me-5" href="<?php 
                        if ($logado){
                            echo "verusuario.php";
                        }else {
                            echo "login.php";
                        }
                    ?>">
                <img src="img/login.png " alt="Logo" width="45" height="45" class="d-inline-block align-itens-end ">
                <h7 style= "font-size: 1.2rem;
            font-weight: bold;"> 
                    <?php 
                        if ($logado){
                            echo $nome;
                        }else {
                            echo "Login";
                        }
                    ?>
                    </h7>
            </a>
        </div>
    </nav>