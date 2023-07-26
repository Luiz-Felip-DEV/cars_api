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

        try {
            $rs->execute();
            $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

            if ($obj)
            {
                die($result = $person->createResponse(200, 'Carro Encontrado com Sucesso!',[
                    'dados'     => $obj
                ]));
            }else{
                die($result = $person->createResponse(200, 'Não Existe Carros Para Retornar!',[
                    ''
                ]));
            }
        }catch (Exception $e) {
            die($result = $person->createResponse(500, 'Não Existe Carro Para Retornar!',[
                'ERROR' => $e->getMessage()
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

        try {
            $rs->execute();
            $obj = $rs->fetchAll(PDO::FETCH_ASSOC);
            if ($obj)
            {
                die($result = $person->createResponse(200, 'Carros Encontrados com Sucesso!',[
                    'dados'     => $obj
                ]));
            }else{
                die($result = $person->createResponse(500, 'Carros Não Encontrado!',[
                    ''
                ]));
            }

        }catch (Exception $e) {

            die($result = $person->createResponse(500, 'Carros Não Encontrado!',[
                'ERROR' => $e->getMessage()
            ]));
        }
      
    }


?>