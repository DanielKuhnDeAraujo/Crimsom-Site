<?php

include("conexao.php");

if(!isset($_POST['nome'],$_POST['email'],$_POST['senha'])){
  header("Location:cadastro.php?erro=falta"); 
  exit;
}
else{
  echo "aaa";
}
$iden =$_POST['nome'];
$email = $_POST['email'];

//Veririca se tem outro com o mesmo nome
$stmt = $conn->prepare('SELECT * FROM usuario where nome like "' . $nome . '"');
$stmt->execute();
if(!($row = $stmt->fetch(PDO::FETCH_ASSOC))){
  header("Location:login.php?erro=nenc"); 
  exit;
}

//Verifica se tem outro com o mesmo email
$stmt = $conn->prepare('SELECT * FROM usuario where email like "' . $email . '"');
$stmt->execute();
if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  header("Location:cadastro.php?erro=repemail"); 
  exit;
}
$nivel='user';
$senha = password_hash($senha,PASSWORD_DEFAULT);
$stmt = $conn->prepare('insert into usuario (nome, email ,senha,nivel) values ("'. $nome . '" , "'. $email . '" , "'. $senha . '" , '. $nivel .');');
$stmt->execute();

session_start();
$_SESSION['nome'] = $nome;
$_SESSION['nivel'] = $nivel;

header("Location:index.php"); 
exit;

?>