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

            $arrData = json_decode(file_get_contents('php://input'), true);

            if (!$arrData)
            {
                $arrData = $_REQUEST;
            }

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

            $data = json_decode(file_get_contents('php://input'), true); 

            if (!$data)
            {
                $data = $_REQUEST;
            }

            if (!$person->allFieldsFilled($data) || !$data)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,''));
            }

            $arrResult = $model->updatePassword($data);

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
            $data = json_decode(file_get_contents('php://input'), true); 

            if (!$data)
            {
                $data = $_REQUEST;
            }

            if (!$person->allFieldsFilled($data) || !$data)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                    ''
                ]));
            }

            $arrResult = $model->updateEmail($data);

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

            $data = json_decode(file_get_contents('php://input'), true); 

            if (!$data)
            {
                $data = explode('#', base64_decode($_REQUEST['hash']));
            }

            if (!$person->allFieldsFilled($data) || !$data)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                    ''
                ]));
            }

            $id                 = (isset($data['id']))            ? $data['id']            : $data[0];
            $telephoneAnti      = (isset($data['old_telephone'])) ? $data['old_telephone'] : $data[1];     
            $telephoneNovo      = (isset($data['new_telephone'])) ? $data['new_telephone'] : $data[2];

            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET telephone = '$telephoneNovo' WHERE id = '$id' AND email = '$telephoneAnti' ");

            try {
                $rs->execute();

                if ($rs->rowCount() > 0) {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA, ''));
                }else{
                    die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
                }
                    
            }catch (Exception $e) {
                die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }
?>