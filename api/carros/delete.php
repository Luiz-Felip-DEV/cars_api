<?php 

    include_once 'classes/functions.php';

    $person = new functions;

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(500, 'Caminho não encontrado!',[
            ''
        ]));
    }

    if ($acao == 'delete')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                ''
            ]));
        }
        
        $db         = DB::connect();
        $hash       = base64_decode($_REQUEST['hash']);

        $rs         = $db->prepare("DELETE FROM cars WHERE id = '$hash'");
        // $rs->execute();

        try {
            $rs->execute();

            die($result = $person->createResponse(200,'Carro Deletado com Sucesso!' ,[
                ''
            ]));
        }catch (Exception $e) {
            die($result = $person->createResponse(500,'Erro ao Deletar Carro!' ,[
                'ERROR' => $e->getMessage()
            ]));
        }

    }



?>