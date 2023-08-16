<?php 

    include_once 'vendor/autoload.php';

    $person = new functions;
    $jwt    = new JWT;
    $model  = new deleteUserModel;

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
        case 'delete':
            break;  
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'delete' && $param == '')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,''));
        }
    
        $id         = base64_decode($_REQUEST['hash']);

        $arrResult  = $model->deleteUser($id);

        if ($arrResult['STATUS'] == 'OK')
        {
            if ($arrResult['DELETE'] == 'TRUE')
            {
                die($person->createResponse(COD_SUCCESS,DELETE_SUCCESS, ''));
            }

            die($person->createResponse(COD_ERROR_BD,NOTHING_FOUND, ''));
        }

        die($person->createResponse(COD_ERROR,DELETE_UNAUTHORIZED ,[
            'ERROR' => $arrResult['MSG']
        ]));

    }

?>