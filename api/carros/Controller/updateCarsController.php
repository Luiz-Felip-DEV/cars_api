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
        case 'update':
            break;
        case 'update-status':
            break;
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }



    if ($acao == 'update')
        {
            if (!isset($_REQUEST['hash']))
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                    ''
                ]));
            }
            $arrParams = explode('#', base64_decode($_REQUEST['hash']));
        
            $db = DB::connect();
            $rs = $db->prepare("UPDATE cars SET name = '$arrParams[1]',brand = '$arrParams[2]', year = '$arrParams[3]', price = '$arrParams[4]', status = '$arrParams[5]' WHERE id = '$arrParams[0]'");

            try {
                $rs->execute();

                if ($rs->rowCount() > 0)
                {
                    $dados = [
                        'id'        => $arrParams[0],
                        'name'      => $arrParams[1],
                        'brand'     => $arrParams[2],
                        'year'      => $arrParams[3],
                        'price'     => $arrParams[4],
                        'status'    => $arrParams[5]
                    ];
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA,[
                        'dados' => $dados
                    ])); 
                } else {
                    die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                        ''
                    ])); 
                }

            }catch (Exception $e) {
                die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }

        if ($acao == 'update-status')
        {
            if (!isset($_REQUEST['hash']))
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                    ''
                ]));
            }
            $arrParams = explode('#', base64_decode($_REQUEST['hash']));
        
            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET status = '$arrParams[1]' WHERE id = '$arrParams[0]'");
         
            try {
                $rs->execute();

                if ($rs->rowCount() > 0)
                {
                    $dados =[
                        'id'        => $arrParams[0],
                        'status'    => $arrParams[1]
                    ];
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA,[
                        'dados' => $dados
                    ])); 
                } else {
                    die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED,[
                        'dados' => $dados
                    ]));
                }

            } catch (Exception $e) {
                die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }
?>