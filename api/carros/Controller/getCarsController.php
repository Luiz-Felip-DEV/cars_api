<?php 

    include_once 'vendor/autoload.php';
    
    $person = new functions;
    $jwt    = new JWT; 
    $model  = new getCarsModel;
    
    $authorizationr     = $_SERVER['HTTP_AUTHORIZATION'];

    if (empty($authorizationr))
    {
        die($person->createResponse(ACCESS_DENIED, TOKEN_NOT_FOUND, ''));
    }

    $arrToken           = explode(' ', $authorizationr);

    $token              = $arrToken[1];

    if (!$jwt->validateJWT($token))
    {
        die($person->createResponse(ACCESS_DENIED, TOKEN_NOT_FOUND, ''));
    }

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
        $arrResult = $model->getCars();

        if ($arrResult['STATUS'] == 'OK')
        {
            if ($arrResult['FOUND'] == 'TRUE')
            {
                die($person->createResponse(COD_SUCCESS, CARS_GET_SUCCESS,[
                    'dados'     => $arrResult['DADOS']
                ]));
            }
            
            die($person->createResponse(COD_ERROR_BD, ERROR_CAR_GET,''));
        }

        die($person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
            'ERROR' => $arrResult['MSG']
        ]));
        
    }

    if ($acao == 'cars-brand')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS, ''));
        }
        
        $brand  = ucwords(base64_decode($_REQUEST['hash']));

        $arrResult = $model->getCarsBrand($brand);

        if ($arrResult['STATUS'] == 'OK')
        {
            if ($arrResult['FOUND'] == 'TRUE')
            {
                die($person->createResponse(COD_SUCCESS, CARS_GET_SUCCESS,[
                    'dados'     => $arrResult['DADOS']
                ]));
            }

            die($person->createResponse(COD_ERROR_BD, CARS_NOT_FOUND,''));
            
        }

        die($person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
            'ERROR' => $arrResult['MSG']
        ]));
      
    }
    
    if ($acao == 'car-id')
    {

        if (!isset($_REQUEST['hash']))
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS, ''));
        }

        $id = base64_decode($_REQUEST['hash']);

        $db     = DB::connect();
        $rs     = $db->prepare("SELECT * FROM cars WHERE id = '$id'");

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