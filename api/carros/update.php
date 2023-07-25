<?php 

    include_once 'classes/functions.php';
    $person = new functions;

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(500, 'Caminho não Encontrado!',[
            ''
        ]));
    }


    if ($acao == 'update')
        {
            if (!isset($_REQUEST['hash']))
            {
                die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                    ''
                ]));
            }
            $arrParams = explode('#', base64_decode($_REQUEST['hash']));
        
            $db = DB::connect();
            $rs = $db->prepare("UPDATE cars SET name = '$arrParams[1]',brand = '$arrParams[2]', year = '$arrParams[3]', price = '$arrParams[4]', status = '$arrParams[5]' WHERE id = '$arrParams[0]'");

            if ($rs->execute())
            {
                die($result = $person->createResponse(200, 'Dados Atualizados com Sucesso!',[
                    ''
                ]));
            }else {
                die($result = $person->createResponse(500, 'Erro ao Atualizar Dados!',[
                    ''
                ]));
            }

        }

        if ($acao == 'update-status')
        {
            if (!isset($_REQUEST['hash']))
            {
                die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                    ''
                ]));
            }
            $arrParams = explode('#', base64_decode($_REQUEST['hash']));
        
            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET status = '$arrParams[1]' WHERE id = '$arrParams[0]'");
            // $rs->execute();

            if ($rs->execute())
            {
                die($result = $person->createResponse(200, 'Dados Atualizados com Sucesso!',[
                    ''
                ]));
            } else {
                die($result = $person->createResponse(500, 'Erro ao Atualizar Dados!',[
                    ''
                ]));
            }
    

        }
?>