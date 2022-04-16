<?php
require_once("../../config.php");
require_once("../header_responser.php");

$action = $_GET["action"] ?? null;

if(!is_null($action)) {

    $id_src = $_GET["id_src"] ?? null;
    $id_dst = $_GET["id_dst"] ?? null;

    switch(strtoupper($action)){
        case "ADD_AMIGO":

            if($id_src != null && $id_dst != null) {
                addAmigos($id_src, $id_dst, $conn);
            }
            break;
        case "DELETE_AMIGO":
            if($id_src != null && $id_dst != null) {
                deleteAmigo($id_src, $id_dst, $conn);
            }
            break;
    }
}

function addAmigos($id_src, $id_dest, $conn) {

    if($id_src != $id_dest) {
        $sql = "select * from tb_amizade WHERE id_pessoa_origem = :ID1 and id_pessoa_destino = :ID2 OR id_pessoa_origem = :ID2 and id_pessoa_destino = :ID1  LIMIT 1";
        $insert = "insert into tb_amizade (id_pessoa_origem, id_pessoa_destino) values (:ID1, :ID2);";

        try {
            // Verificando se já são amigos
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":ID1", $id_dest, PDO::PARAM_INT);
            $stmt->bindParam(":ID2", $id_src, PDO::PARAM_INT);
            $stmt->execute();

            if(!$stmt->rowCount()) {

                // Caso não seja amigos, adicionar na listagem
                $stmt =  $conn->prepare($insert);
                $stmt->bindParam(":ID1", $id_src, PDO::PARAM_INT);
                $stmt->bindParam(":ID2", $id_dest, PDO::PARAM_INT);

                if($stmt->execute()) {
                    ResponseCampos(array(
                        "status" => true
                    ));
                } else {
                    ResponseCampos(array(
                        "erro" => "Problema ao enviar a solicitação de amizade!"
                    ));
                }

                
            } else {
                ResponseCampos(array(
                    "erro" => "Solicitação já enviada!"
                ));
            }
        } catch(PDOException $e) {
            ResponseCampos(array(
                "erro" => $e->getMessage(),
                "code" => $e->getCode()
            ));
        }
    }

}

function deleteAmigo($id_src, $id_dst, $conn) {
    $sql = "delete from tb_amizade WHERE id_pessoa_origem = :ID1 and id_pessoa_destino = :ID2 OR id_pessoa_origem = :ID2 and id_pessoa_destino = :ID1  LIMIT 1";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":ID1", $id_src, PDO::PARAM_INT);
        $stmt->bindParam(":ID2", $id_dst, PDO::PARAM_INT);

        $stmt->execute();

        if($stmt->rowCount()){
            ResponseCampos(array(
                "status" => true
            ));
        } else {
            ResponseCampos(array(
                "erro" => "Amizade já foi cancelada!"
            ));
        }

    } catch(PDOException $e) {
        ResponseCampos(array(
            "erro" => $e->getMessage(),
            "code" => $e->getCode()
        ));
    }
    
}