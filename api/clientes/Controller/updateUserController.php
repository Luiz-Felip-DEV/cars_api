<?php 

    include_once 'vendor/autoload.php';
    
    $person = new functions;
    $jwt    = new JWT;
    $model  = new updateUserModel;

    $authorizationr     = $_SERVER['HTTP_AUTHORIZATION'];

    if (empty($authorizationr))
    {
        die($person->createResponse(ACCESS_DENIED, TOKEN_NOT_FOUND, ''));
    }

    $arrData = $_REQUEST;

    if (!$arrData)
    {
        $arrData = json_decode(file_get_contents('php://input'), true);
    }

    if (!isset($arrData['id_user']) || isset($arrData['id_user']) && empty($arrData['id_user']))
    {
        die($person->createResponse(COD_ERROR_FOUND, ID_USER_INVALID, ''));
    }

    $idUser    = $arrData['id_user'];
    $arrToken  = explode(' ', $authorizationr);
    $token     = $arrToken[1];

    if (!$jwt->validateJWT($token, $idUser))
    {
        die($person->createResponse(ACCESS_DENIED, TOKEN_INVALID, ''));
    }

    if ($acao == '' && $param == '')
    {
        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'update':
            break;
        case 'update-password':
            break;
        case 'update-telephone':
            break;
        case 'update-email':
            break;  
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }


    if ($acao == 'update')
    {
        if (!$person->allFieldsFilled($arrData) || !$arrData)
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,'')); 
        }

        $arrData['telephone'] = $person->formatedNumber($arrData['telephone']);
            
        $arrResult = $model->update($arrData);

        if ($arrResult['STATUS'] == 'OK')
        {
            if ($arrResult['UPDATE'] == 'TRUE')
            {
                die($person->createResponse(COD_SUCCESS, UPDATED_DATA,[
                    'dados' => $arrResult['DADOS']
                ]));
            }

            die($person->createResponse(COD_ERROR, ID_NOT_EXISTS,''));          
        }

        die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
            'ERROR' => $arrResult['MSG']
        ]));


    }

        if ($acao == 'update-password')
        {
            if (!$person->allFieldsFilled($arrData) || !$arrData)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,''));
            }

            $oldPassword    = $person->bringPassword($idUser);
            $verifyPassword = password_verify($arrData['old_password'], $oldPassword);

           if (!$verifyPassword)
           {
                die($person->createResponse(COD_ERROR, PASSWORD_INVALID,''));
           }

            $arrData['new_password'] = password_hash($arrData['new_password'], PASSWORD_DEFAULT);

            $arrResult = $model->updatePassword($arrData);

            if ($arrResult['STATUS'] == 'OK')
            {
                if ($arrResult['UPDATE'] == 'TRUE')
                {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA, $arrResult['DADOS']));
                } 

                die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
            }

            die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                'ERROR' => $arrResult['MSG']
            ]));
            
        }

        if ($acao == 'update-email')
        {
            if (!$person->allFieldsFilled($arrData) || !$arrData)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,''));
            }

            $arrResult = $model->updateEmail($arrData);

            if ($arrResult['STATUS'] == 'OK')
            {
                if ($arrResult['UPDATE'] == 'TRUE')
                {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA, $arrResult['DADOS']));
                }

                die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
            }

            die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                'ERROR' => $arrResult['MSG']
            ]));
        }

        if ($acao == 'update-telephone')
        {
            if (!$person->allFieldsFilled($arrData) || !$arrData)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,''));
            }

            $arrData['old_telephone'] = $person->formatedNumber($arrData['old_telephone']);
            $arrData['new_telephone'] = $person->formatedNumber($arrData['new_telephone']);

            if (!$person->verifyTelephone($arrData['new_telephone']))
            {
                die($person->createResponse(COD_ERROR, TELEPHONE_IS_ALREADY_DATABASE, ''));
            }

            $arrResult = $model->updateTelephone($arrData);

            if ($arrResult['STATUS'] == 'OK')
            {
                if ($arrResult['UPDATE'] == 'TRUE')
                {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA, $arrResult['DADOS']));
                }

                die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
            }

            die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                'ERROR' => $arrResult['MSG']
            ]));
        }
?>