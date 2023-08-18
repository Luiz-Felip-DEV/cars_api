<?php 

    include_once 'vendor/autoload.php';

    $person = new functions;
    $model  = new deleteCarsModel;

    if ($acao == '' && $param == ''){
        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'delete':
            break; 
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'delete')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS, ''));
        }
        
        $id       = base64_decode($_REQUEST['hash']);

        $arrResult = $model->deleteCar($id);

        if ($arrResult['STATUS'] == 'OK')
        {
            if ($arrResult['DELETE'] == 'TRUE')
            {
                die($person->createResponse(COD_SUCCESS,DELETE_SUCCESS ,''));
            }

            die($person->createResponse(COD_ERROR_BD,NOTHING_FOUND, ''));
        }

        die($person->createResponse(COD_ERROR,DELETE_UNAUTHORIZED ,[
            'ERROR' => $arrResult['MSG']
        ]));

    }



?>