<?php 

    include_once 'classes/functions.php';
    include_once 'classes/mensagens.php';

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
        
        $db                 = DB::connect();        
        $arrHash            = explode('#', base64_decode($_POST['hash']));
        $valor_formatado    = number_format($arrHash[3], 2, ',', '.');

        # $hash = base64_encode($nome .'#'. $sobrenome.'#'. $idade.'#'.$email.'#'.$senha.'#'.$telefone);
        $rs         = $db->prepare("INSERT INTO cars (name, brand, year, price, status) VALUES ('$arrHash[0]', '$arrHash[1]', '$arrHash[2]', '$valor_formatado', '$arrHash[4]')");

        try {
            $rs->execute();
            $id = $db->lastInsertId();
            $dados = [
                'id'        => $id,
                'name'      => $arrHash[0],
                'brand'     => $arrHash[1],
                'year'      => $arrHash[2],
                'price'     => $valor_formatado,
                'status'    => $arrHash[4] 
            ];

            die($result = $person->createResponse(200,'Carro Cadastrado com Sucesso!' ,[
                'dados' => $dados
            ]));
        }catch (Exception $e){
            die($result = $person->createResponse(500,'Erro ao Cadastrar Carro!' ,[
                'ERROR' => $e->getMessage()
            ]));
        }
    
    }

?>