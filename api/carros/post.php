<?php 

    include_once 'classes/functions.php';

    $person = new functions;


    if ($acao == '' && $param == ''){
        
        die($result = $person->createResponse(500, 'Caminho não encontrado!',[
            ''
        ]));
    }

    if ($acao == 'insert')
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
        $rs         = $db->prepare("INSERT INTO cars (name, brand, year, price, status) VALUES ('$arrHash[0]', '$arrHash[1]', '$arrHash[2]', '$arrHash[3]', '$arrHash[4]')");

        try {
            $rs->execute();
            die($result = $person->createResponse(200,'Carro Cadastrado com Sucesso!' ,[
                ''
            ]));
        }catch (Exception $e){
            die($result = $person->createResponse(500,'Erro ao Cadastrar Carro!' ,[
                ''
            ]));
        }
    
    }

?>