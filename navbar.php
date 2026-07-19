<?php 
$logado = false;
if(isset($_SESSION['nome'])){
    $logado= true;
    $nom = $_SESSION['nome'];
} ?>



    <?php
$logado = false;
if (isset($_SESSION['nome'])) {
    $logado = true;
    $nom = $_SESSION['nome'];
}
?>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand ms-2" href="index.php">
            <img src="img/logo.png" width="60" height="50" alt="Logo">
            <b>Crimsom Beasts</b>
        </a>

        <!-- Botão do celular -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Conteúdo -->
        <div class="collapse navbar-collapse bg-dark p-3 p-md-0" id="navbarMenu">

            <!-- Empurra os links para a direita -->
            <div class="ms-auto d-lg-flex align-items-center">

                <a href="pacotinho.php"
                   class="nav-link fw-bold me-lg-5 navbar-bran"  style= "font-size: 1.2rem;font-weight: bold;">
                    Pacotinho
                </a>

                <a class="nav-link d-flex align-items-center navbar-brand" style= "font-size: 1.2rem;font-weight: bold;"
                   href="<?= $logado ? 'verusuario.php' : 'login.php' ?>">

                    <img src="img/login.png" width="45" height="45" class="me-2">

                    <?= $logado ? $nom : 'Login' ?>

                </a>

            </div>

        </div>

    </div>
</nav>