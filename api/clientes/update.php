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

            $data = date("Y-m-d", strtotime($arrParams[3])); 
        
            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET name = '$arrParams[1]', last_name = '$arrParams[2]', birth_date = '$data', email = '$arrParams[4]', password = '$arrParams[5]', telephone = '$arrParams[6]' WHERE id = '$arrParams[0]'");
            try {
                $rs->execute();

                die($result = $person->createResponse(200, 'Dados Atualizados com Sucesso!',[
                    ''
                ]));
            } catch (Exception $e) {
                die($result = $person->createResponse(500, 'Erro ao Atualizar Dados!',[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }

?>