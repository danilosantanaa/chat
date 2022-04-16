<?php

function ValidarUsuario($usuario) {
    if(strlen($usuario) <= 6) {
        return array(
            "erro" => strlen($usuario) == 0 ? "O usuairo deve ser informado" : "O usuairo deve ter pelo menos 6 caracteres",
            "field" => "usuario"
        );
    } else if(strripos($usuario, " ")) {
            return array(
                "erro" => "O nome de usuário inválido!",
                "field" => "usuario"
            );
         
    }

    return [];
}