<?php

    include_once 'vendor/autoload.php';
    
    $person = new functions;
    $model  = new getModel; 

    if ($acao == '' && $param == ''){
        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'user':
            break;  
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'user')  
    { 
        if (!isset($_REQUEST['hash']))
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS, ''));
        }

        $id = base64_decode($_GET['hash']);
        
        $arrResult = $model->getUser($id);

        if ($arrResult['STATUS'] == 'OK')
        {
            if ($arrResult['FOUND'] == 'TRUE')
            {
                die($person->createResponse(COD_SUCCESS, USER_FOUND,[
                    'dados'     => $arrResult['DADOS']
                ]));
            }

            die($person->createResponse(COD_ERROR_BD, ERROR_USER_GET, ''));
        }

        die($person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
            'ERROR' => $arrResult['MSG']
        ]));
        
    }

?>