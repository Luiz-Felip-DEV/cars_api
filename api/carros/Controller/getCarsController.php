<?php 

    include_once 'vendor/autoload.php';
    
    $person = new functions; 

    if ($acao == '' && $param == ''){
        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'cars':
            break;
        case 'cars-brand':
            break;
        case 'car-id':
            break;  
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'cars')
    {
        echo "estou aqui";
        exit;
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM cars ORDER BY id");

        try {
            $rs->execute();
            $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

            if ($obj)
            {
                die($person->createResponse(COD_SUCCESS, CARS_GET_SUCCESS,[
                    'dados'     => $obj
                ]));
            }else{
                die($person->createResponse(COD_ERROR_BD, ERROR_CAR_GET,[
                    ''
                ]));
            }
        }catch (Exception $e) {
            die($person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
                'ERROR' => $e->getMessage()
            ]));
        }
        
    }

    if ($acao == 'cars-brand')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS, ''));
        }
        
        $modelo = base64_decode($_REQUEST['hash']);
        $db     = DB::connect();
        $rs     = $db->prepare("SELECT * FROM cars WHERE brand = '{$modelo}' ORDER BY id");

        try {
            $rs->execute();
            $obj = $rs->fetchAll(PDO::FETCH_ASSOC);
            if ($obj)
            {
                die($person->createResponse(COD_SUCCESS, CARS_GET_SUCCESS,[
                    'dados'     => $obj
                ]));
            }else{
                die($person->createResponse(COD_ERROR_BD, CARS_NOT_FOUND,[
                    ''
                ]));
            }

        }catch (Exception $e) {

            die($person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
                'ERROR' => $e->getMessage()
            ]));
        }
      
    }
    
    if ($acao == 'car-id')
    {

        if (!isset($_REQUEST['hash']))
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS, ''));
        }

        $id = base64_decode($_REQUEST['hash']);

        $db     = DB::connect();
        $rs     = $db->prepare("SELECT * FROM cars WHERE id = '{$id}'");

        try {
            $rs->execute();
            $obj = $rs->fetchObject();

            if ($obj) {
                die($person->createResponse(COD_SUCCESS, CAR_SUCCESS,[
                    'dados'     => $obj
                ]));
                
            } else {
                die($person->createResponse(COD_ERROR_BD, CAR_NOT_FOUND,[
                    ''
                ]));
            }

        }catch (Exception $e) {
            die($person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
                'ERROR' => $e->getMessage()
            ]));
        }

    }


?>