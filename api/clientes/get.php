<?php
include_once 'classes/functions.php';
$person = new functions; 

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(500, 'Caminho não Encontrado!', ''));
    }

    if ($acao == 'lista' && $param !== '')
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM users WHERE id = {$param}");

        try {
            $rs->execute();
            $obj = $rs->fetchObject();

            if ($obj)
            {
                die($result = $person->createResponse(200, 'Usuario Encontrado com Sucesso!',[
                    'dados'     => $obj
                ]));
            }else{
                die($result = $person->createResponse(200, 'Não Existe Usuarios Para Retornar!',[
                    ''
                ]));
            }
        }catch (Exception $e) {
            die($result = $person->createResponse(500, 'Não Existe Usuarios Para Retornar!',[
                'ERROR' => $e->getMessage()
            ]));
        }
        
    }

    if ($acao == 'login')
    {

        if (!isset($_GET['hash']))
            {
                die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                    ''
                ]));
            }
            
        $arrParams = explode('#',base64_decode($_GET['hash']));
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM users WHERE email = '$arrParams[0]' AND password = '$arrParams[1]' ");
        try {
            $rs->execute();
            $obj = $rs->fetchObject();

            if ($obj) 
            {
                die($result = $person->createResponse(200, 'Usuario Autorizado com Sucesso!',[
                    'dados'     => $obj
                ]));
            }else {
                die($result = $person->createResponse(500, 'Usuario Não Encontrado!',[
                    ''
                ]));
            }
        } catch (Exception $e) {
            die($result = $person->createResponse(500, 'Dados Inválidos!',[
                'ERROR' => $e->getMessage()
            ]));
        }

    }
?>