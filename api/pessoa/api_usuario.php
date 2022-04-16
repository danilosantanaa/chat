<?php
require_once("../header_responser.php");
require_once("validador.php");
require_once("../../config.php");

$id = $_GET["id"] ?? "0";

foreach($_POST as $key => $post) {
    $_POST[$key] = htmlentities($post);
}

$nome = trim($_POST["nome"] ?? "");
$usuario = trim($_POST["usuario"] ?? "");
$senha = trim($_POST["senha"] ?? "");
$senhaConfirm = trim($_POST["senhaConf"] ?? "");

$erro_array = [];

// Montando a QUERY
if($id == "0")
    $sql = "insert into tb_pessoa (nome, usuario, senha) values (:NOME, :USUARIO, :SENHA);";
else 
    $sql = "update tb_pessoa set nome = :NOME ". ($senha != "" ? ", senha = :SENHA" : "") ." WHERE id_pessoa = :ID;";

$stmt = $conn->prepare("insert into tb_pessoa (nome, usuario, senha) values (:NOME, :USUARIO, :SENHA);");
// Validando o NOME
if(strlen($nome) <= 6) {
   array_push($erro_array, array(
        "erro" => strlen($nome) == 0 ? "O nome deve ser informado" : "O nome deve ter pelo menos 6 caracteres",
        "field" => "nome"
   ));
} else {
    $stmt->bindParam(":NOME", $nome, PDO::PARAM_STR);
}

// Validando o USUARIO
if($id == "0") {
    $user_invalido = ValidarUsuario($usuario);
    if(count($user_invalido) > 0 ) {
        array_push($erro_array, $user_invalido);
    } else {
        $stmt->bindParam(":USUARIO", $usuario, PDO::PARAM_STR);
    }
} 

// VALIDANDO a senha
if($id == "0" || $id != "0" && $senha != "") {
    if(strlen($senha) < 8) {
        array_push($erro_array, array(
            "erro" => strlen($senha) == 0 ? "A senha deve ser informado" : "A senha deve ter pelo menos 8 caracteres",
            "field" => "senha"
        ));
    } else if($senha != $senhaConfirm) {
        array_push($erro_array, array(
            "erro" => "A senha de confirmação inválido!",
            "field" => "senha"
        ));
        
    } else {
        $stmt->bindParam(":SENHA", $usuario, PDO::PARAM_STR);
    }
}

// Lançar erro caso tiver erro esteja errado
if(count($erro_array) > 0) ResponseCampos($erro_array);


try {

    // Caso for edição
    if($id != 0) {
        $stmt->bindParam(":ID", $id, PDO::PARAM_INT);
    }

    $stmt->execute();
    ResponseCampos(array(
        "status" => true
    ));
} catch(PDOException $e) {
    ResponseCampos(array(
        "erro" => $e->getMessage(),
        "code" => $e->getCode()
    ));
} 