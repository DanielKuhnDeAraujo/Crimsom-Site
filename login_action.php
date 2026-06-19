<?php
session_start();
include("conexao.php");

if(!isset($_POST['senha'],$_POST['ident'])){
  header("Location:login.php?erro=falta"); 
  exit;
}
$ident =$_POST['ident'];
$senha = $_POST['senha'];

//Veririca se tem com esse nome ou email
$achou = false;
$stmt = $conn->prepare('SELECT * FROM usuario where nome like "' . $ident . '"');
$stmt->execute();
if(($row = $stmt->fetch(PDO::FETCH_ASSOC))){
    $achou = true;
    $senhacerta = $row['SENHA'];
    $identipo = "nome";
    $nivel = $row['NIVEL'];
    $nome = $ident;
}
$stmt = $conn->prepare('SELECT * FROM usuario where email like "' . $ident . '"');
$stmt->execute();
if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $achou=true;
        $senhacerta = $row['SENHA'];
        $identipo = "email";
        $nivel = $row['NIVEL'];
        $nome = $row['NOME'];
} 
if (!$achou) {
    header("Location:login.php?erro=nenc"); 
    exit;
}

echo ($senhacerta);
echo $senha;
if( password_verify($senha,$senhacerta)){
        $_SESSION['nome'] = $ident;
        $_SESSION['nivel'] = $nivel;
}
else {
    header("Location:login.php?erro=senha"); 
    exit;
}

 header("Location:index.php"); 
 exit;

?>