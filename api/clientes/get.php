<?php

    include_once 'vendor/autoload.php';
    
    $person = new functions;
    $jwt    = new JWT; 

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'user':
            break;  
        default:
            die($result = $person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'user')  
    { 
        if (!isset($_REQUEST['hash']))
        {
            die($result = $person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS, ''));
        }

        $id = base64_decode($_GET['hash']);
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM users WHERE id = '$id'");

        try {
            $rs->execute();
            $obj = $rs->fetchObject();

            if ($obj)
            {
                die($result = $person->createResponse(COD_SUCCESS, USER_FOUND,[
                    'dados'     => $obj
                ]));
            }else{
                die($result = $person->createResponse(COD_ERROR_BD, ERROR_USER_GET,[
                    ''
                ]));
            }
        }catch (Exception $e) {
            die($result = $person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
                'ERROR' => $e->getMessage()
            ]));
        }
        
    }

?>