<?php 

include_once 'classes/functions.php';
$person = new functions;

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(500, 'Caminho não Encontrado!',[
            ''
        ]));
    }


    if ($acao == 'atualizar')
        {
            if (!isset($_REQUEST['hash']))
            {
                die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                    ''
                ]));
            }
            $arrParams = explode('#', base64_decode($_REQUEST['hash']));
        
            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET name = '$arrParams[1]', last_name = '$arrParams[2]', age = '$arrParams[3]', email = '$arrParams[4]', password = '$arrParams[5]', telefone = '$arrParams[6]' WHERE id = '$arrParams[0]'");
            $rs->execute();

            die($result = $person->createResponse(200, 'Dados Atualizados com Sucesso!',[
                        ''
                    ]));

        }

?>