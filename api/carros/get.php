<?php 

    include_once 'classes/functions.php';
    $person = new functions; 

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(500, 'Caminho não Encontrado!',[
            ''
        ]));
    }

    if ($acao == 'carros')
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM cars ORDER BY id");
        $rs->execute();
        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);
        
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

    if ($acao == 'cars-brand')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                ''
            ]));
        }
        $modelo = base64_decode($_REQUEST['hash']);
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM cars WHERE brand = '{$modelo}' ORDER BY id");
        $rs->execute();
        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);
        
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


?>