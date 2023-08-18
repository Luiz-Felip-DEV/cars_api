<?php 

    include_once 'vendor/autoload.php';
    
    $person = new functions;
    $jwt    = new JWT;
    $model  = new updateCarsModel;

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
        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND,''));
    }

    switch ($acao)
    {
        case 'update':
            break;
        case 'update-status':
            break;
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }



    if ($acao == 'update')
        {
            $arrData = json_decode(file_get_contents('php://input'), true);

            if (!$arrData)
            {
                $arrData = $_REQUEST;
            }

            if (!$person->allFieldsFilled($arrData) || !$arrData)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,'')); 
            }

            if (str_contains($arrData['price'], '.'))
            {
                $arrData['price'] = str_replace(".", "", $arrData['price']);
            }

            if (str_contains($arrData['price'], ','))
            {
                $arrData['price'] = str_replace(",", "", $arrData['price']);
            }

            if (empty($arrData['id']))
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,''));
            }

            $arrResult = $model->updateCar($arrData);
            
            if ($arrResult['STATUS'] == 'OK')
            {
                if ($arrResult['UPDATE'] == 'TRUE')
                {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA,[
                        'dados' => $arrResult['DADOS']
                    ]));
                }
                
                die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,''));    
            }

            die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                'ERROR' => $arrResult['MSG']
            ]));

        }

        if ($acao == 'update-status')
        {
            $arrData = json_decode(file_get_contents('php://input'), true);

            if (!$arrData)
            {
                $arrData = $_REQUEST;
            }

            if (!$person->allFieldsFilled($arrData) || !$arrData)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,'')); 
            }
        
            $arrResult = $model->updateStatus($arrData);

            if ($arrResult['STATUS'] == 'OK')
            {
                if ($arrResult['UPDATE'] == 'TRUE')
                {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA,[
                        'dados' => $arrResult['DADOS']
                    ]));
                }

                die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED,'')); 
            }

            die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                'ERROR' => $arrResult['MSG']
            ]));

        }
?>