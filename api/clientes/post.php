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

        try {
            $rs->execute();
            
            $dados = [
                'name' => $arrHash[0],
                'last_name' => $arrHash[1],
                'dt_nascimento' => $arrHash[2],
                'email' => $arrHash[3],
                'password' => $arrHash[4],
                'telefone' => $arrHash[5]
            ];

            die($result = $person->createResponse(200,'Usuario Cadastrado com Sucesso!' ,[
                'dados' => $dados
            ]));
        }catch (Exception $e) {
            die($result = $person->createResponse(500,'Erro ao Cadastrar Usuario!' ,[
                'ERROR' => $e->getMessage()
            ]));
        }

    }


?>