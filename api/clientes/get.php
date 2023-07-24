<?php
include_once 'classes/functions.php';
$person = new functions; 

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(500, 'Caminho não Encontrado!',[
            ''
        ]));
    }
    if ($acao == 'lista' && $param == '')
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM users ORDER BY name");
        $rs->execute();
        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);
        
        if ($obj)
        {
            die($result = $person->createResponse(200, 'Usuarios Encontrados!',[
                'dados'     => $obj
            ]));
    
        }else{
            die($result = $person->createResponse(200, 'Não Existe Usuarios Para Retornar!',[
                ''
            ]));
        }
    }

    if ($acao == 'lista' && $param !== '')
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM users WHERE id = {$param}");
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
    }

    if ($acao == 'login')
    {

        if (!isset($_REQUEST['hash']))
            {
                die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                    ''
                ]));
            }
        $arrParams = explode('#',base64_decode($_GET['hash']));
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM users WHERE email = '$arrParams[0]' AND password = '$arrParams[1]' ");
        $rs->execute();
        $obj = $rs->fetchObject();
        if ($obj) 
        {
            die($result = $person->createResponse(200, 'Usuario Autorizado com Sucesso!',[
                'dados'     => $obj
            ]));
        }else {
            die($result = $person->createResponse(500, 'Dados Inválidos!',[
                ''
            ]));
        }
    }
?>