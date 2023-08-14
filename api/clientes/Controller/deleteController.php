<?php 

    include_once 'vendor/autoload.php';

    $person = new functions;
    $jwt    = new JWT;

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
        
        $db         = DB::connect();
        $id         = base64_decode($_REQUEST['hash']);

        $rs         = $db->prepare("DELETE FROM users WHERE id = '$id'");

        try {
            $rs->execute();
            if ($rs->rowCount() > 0)
            {
                die($person->createResponse(COD_SUCCESS,DELETE_SUCCESS ,[
                    ''
                ]));
            } else {
                die($person->createResponse(COD_ERROR_BD,NOTHING_FOUND ,[
                    ''
                ]));
            }
        } catch (Exception $e) {
            die($person->createResponse(COD_ERROR,DELETE_UNAUTHORIZED ,[
                'ERROR' => $e->getMessage()
            ]));
        }
    }

?>