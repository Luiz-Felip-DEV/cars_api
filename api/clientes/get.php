<?php

    include_once 'vendor/autoload.php';
    
    $person = new functions; 

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(COD_ERROR, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'user':
            break;
        case 'login':
            break;  
        default:
            die($result = $person->createResponse(COD_ERROR, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'user')  
    {
        if (!isset($_REQUEST['hash']))
        {
            die($result = $person->createResponse(COD_ERROR, WRONG_PARAMETERS, ''));
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

    if ($acao == 'login')
    {
        if (!isset($_GET['hash']))
            {
                die($result = $person->createResponse(COD_ERROR, WRONG_PARAMETERS,[
                    ''
                ]));
            }
            
        $arrParams = explode('#',base64_decode($_GET['hash']));
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM users WHERE email = '$arrParams[0]' AND password = '$arrParams[1]' ");
        try {
            $rs->execute();
            $obj = $rs->fetchObject();

            if ($obj) 
            {
                die($result = $person->createResponse(COD_SUCCESS, LOGIN_SUCCESS,[
                    'dados'     => $obj
                ]));
            }else {
                die($result = $person->createResponse(COD_ERROR_BD, LOGIN_UNAUTHORIZED,[
                    ''
                ]));
            }
        } catch (Exception $e) {
            die($result = $person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
                'ERROR' => $e->getMessage()
            ]));
        }
    }

?>