<?php
include_once 'classes/functions.php';
include_once 'vendor/autoload.php';

$person = new functions;

    if ($acao == '' && $param == ''){

        die($result = $person->createResponse(500, 'Caminho não Encontrado!', ''));
    }

    if ($acao == 'insert' && $param == '')
    {
        if (!isset($_POST['hash']))
        {
            die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                ''
            ]));
        }
        
        $db         = DB::connect();
        $hash       = base64_decode($_POST['hash']);
        $arrHash    = explode('#', $hash);

        # $hash = base64_encode($nome .'#'. $sobrenome.'#'. $idade.'#'.$email.'#'.$senha.'#'.$telefone);
        $data = date("Y-m-d", strtotime($arrHash[2])); 

        $rs         = $db->prepare("INSERT INTO users (name, last_name, birth_date, email, password, telephone) VALUES ('$arrHash[0]', '$arrHash[1]', '$data', '$arrHash[3]', '$arrHash[4]', '$arrHash[5]')");

        try {
            $rs->execute();
            $id = $db->lastInsertId();
            
            $dados = [
                'id' => $id,
                'name' => $arrHash[0],
                'last_name' => $arrHash[1],
                'dt_nascimento' => $data,
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