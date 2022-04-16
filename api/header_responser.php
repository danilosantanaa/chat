<?php
header('Content-Type: application/json;charset=utf-8');

function ResponseInvalid(){
    die(json_encode(array(
        "erro" => "método inválido!"
    )));
}

function ResponseCampos($array){
    die(json_encode(array(
        $array
    )));

    die();
}

function Debug($obj) {
    print_r(json_encode($obj));
}