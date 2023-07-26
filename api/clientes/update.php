<?php 

include_once 'classes/functions.php';
$person = new functions;

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(500, 'Caminho não Encontrado!', ''));
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
                
                if ($rs->rowCount() > 0) 
                {
                    $dados = [
                        'id'            => $arrParams[0],
                        'name'          => $arrParams[1],
                        'last_name'     => $arrParams[2],
                        'dt_nascimento' => $data,
                        'email'         => $arrParams[4],
                        'password'      => $arrParams[5],
                        'telefone'      => $arrParams[6]
                    ];

                    die($result = $person->createResponse(200, 'Dados Atualizados com Sucesso!',[
                        'dados' => $dados
                    ]));
                    
                } else {
                    die($result = $person->createResponse(500, 'Erro ao Atualizar Dados!',''));
                }

            } catch (Exception $e) {
                die($result = $person->createResponse(500, 'Erro ao Atualizar Dados!',[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }

        if ($acao == 'update-password')
        {
            if (!isset($_REQUEST['hash']))
            {
                die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                    ''
                ]));
            }

            $arrParams = explode('#', base64_decode($_REQUEST['hash']));

            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET password = '$arrParams[2]' WHERE id = '$arrParams[0]' AND password = '$arrParams[1]'");
            
            try {
                $rs->execute();

                if ($rs->rowCount() > 0) {
                    die($result = $person->createResponse(200, 'Senha Atualizada com Sucesso!', ''));
                }else{
                    die($result = $person->createResponse(500, 'Senha ou Id Inválidos!', ''));
                }
                    
            }catch (Exception $e) {
                die($result = $person->createResponse(500, 'Erro ao Atualizar Senha!',[
                    'ERROR' => $e->getMessage()
                ]));
            }
        }

?>