<?php
include_once 'classes/functions.php';

$person = new functions;

    if ($acao == '' && $param == ''){
        echo json_encode(['ERRO' => 'Caminho não encontrado']);
    }

    if ($acao == 'adiciona' && $param == '')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                ''
            ]));
        }
        
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


?>