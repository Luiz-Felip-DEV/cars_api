<?php 

    include_once 'classes/functions.php';
    include_once 'classes/mensagens.php';
    $person = new functions;

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(500, 'Caminho não Encontrado!',''));
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

            try {
                $rs->execute();

                if ($rs->rowCount() > 0)
                {
                    $dados = [
                        'id' => $arrParams[0],
                        'name' => $arrParams[1],
                        'brand' => $arrParams[2],
                        'year' => $arrParams[3],
                        'price' => $arrParams[4],
                        'status' => $arrParams[5]
                    ];
                    die($result = $person->createResponse(200, 'Dados Atualizados com Sucesso!',[
                        'dados' => $dados
                    ])); 
                } else {
                    die($result = $person->createResponse(500, 'Erro ao Atualizar Dados, Carro não Encontrado!',[
                        ''
                    ])); 
                }

            }catch (Exception $e) {
                die($result = $person->createResponse(500, 'Erro ao Atualizar Dados!',[
                    'ERROR' => $e->getMessage()
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
            try {
                $rs->execute();

                if ($rs->rowCount() > 0)
                {
                    $dados =[
                        'id'        => $arrParams[0],
                        'status'    => $arrParams[1]
                    ];
                    die($result = $person->createResponse(200, 'Dados Atualizados com Sucesso!',[
                        'dados' => $dados
                    ])); 
                }

            } catch (Exception $e) {
                die($result = $person->createResponse(500, 'Erro ao Atualizar Dados!',[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }
?>