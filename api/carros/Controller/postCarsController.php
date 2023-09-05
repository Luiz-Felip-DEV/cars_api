<?php 

    include_once 'vendor/autoload.php';

    $person = new functions;
    $jwt    = new JWT;
    $model  = new postCarsModel;

    $arrDados = $_POST;

    if (!isset($arrDados['id_user']) || isset($arrDados['id_user']) && empty($arrDados['id_user']))
    {
        die($person->createResponse(COD_ERROR_FOUND, ID_USER_INVALID, ''));
    }


    if (!$arrDados)
    {
        $arrDados = json_decode(file_get_contents('php://input'), true);
    }

    $idUser = $arrDados['id_user'];

    $authorizationr     = $_SERVER['HTTP_AUTHORIZATION'];

    if (empty($authorizationr))
    {
        die($person->createResponse(ACCESS_DENIED, TOKEN_NOT_FOUND, ''));
    }

    $arrToken           = explode(' ', $authorizationr);

    $token              = $arrToken[1];

    if (!$jwt->validateJWT($token, $idUser))
    {
        die($person->createResponse(ACCESS_DENIED, TOKEN_INVALID, ''));
    }


    if ($acao == '' && $param == ''){
        
        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND,[
            ''
        ]));
    }

    switch ($acao)
    {
        case 'insert':
            break; 
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'insert')
    {

        if (!$person->allFieldsFilled($arrDados) || !$arrDados)
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,''));
        }
        
        if (str_contains($arrDados['price'], '.'))
        {
            $arrDados['price'] = str_replace(".", "", $arrDados['price']);
        }

        if (str_contains($arrDados['price'], ','))
        {
            $arrDados['price'] = str_replace(",", "", $arrDados['price']);
        }
        
        $arrResult = $model->insertCar($arrDados);
        
        if ($arrResult['STATUS'] == 'OK')
        {
            die($person->createResponse(COD_SUCCESS,CAR_INSERTED ,[
                'dados' => $arrResult['DADOS']
            ]));
        }

        die($person->createResponse(COD_ERROR, ERROR_CAR_INSERTED ,[
            'ERROR' => $arrResult['MSG']
        ]));
    
    }

?>