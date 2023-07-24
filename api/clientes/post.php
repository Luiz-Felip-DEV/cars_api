<?php
include_once 'classes/functions.php';

$person = new functions;

    if ($acao == '' && $param == ''){
        echo json_encode(['ERRO' => 'Caminho não encontrado']);
    }

    if ($acao == 'adiciona' && $param == '')
    {
        $db         = DB::connect();
        $hash       = base64_decode($_POST['hash']);
        $arrHash    = explode('#', $hash);

        # $hash = base64_encode($nome .'#'. $sobrenome.'#'. $idade.'#'.$email.'#'.$senha.'#'.$telefone);
        $rs         = $db->prepare("INSERT INTO users (name, last_name, age, email, password, telefone) VALUES ('$arrHash[0]', '$arrHash[1]', '$arrHash[2]', '$arrHash[3]', '$arrHash[4]', '$arrHash[5]')");
        $rs->execute();

        die($result = $person->createResponse(200,'Usuario Cadastrado com Sucesso!' ,[
            ''
        ]));
    }

    if ($acao == 'delete' && $param == '')
    {
        $db         = DB::connect();
        $hash       = base64_decode($_POST['hash']);

        $rs         = $db->prepare("DELETE FROM users WHERE id = '$hash'");
        $rs->execute();

        die($result = $person->createResponse(200,'Usuario Deletado com Sucesso!' ,[
            ''
        ]));
    }

?>