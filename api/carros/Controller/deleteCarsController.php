<?php 

    include_once 'vendor/autoload.php';

    $person = new functions;

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
        
        $db         = DB::connect();
        $hash       = base64_decode($_REQUEST['hash']);

        $rs         = $db->prepare("DELETE FROM cars WHERE id = '$hash'");

        try {
            $rs->execute();

            if ($rs->rowCount() > 0)
            {
                die($person->createResponse(COD_SUCCESS,DELETE_SUCCESS ,''));
            } else {
                die($person->createResponse(COD_ERROR_BD,NOTHING_FOUND, ''));
            }

        }catch (Exception $e) {
            die($person->createResponse(COD_ERROR,DELETE_UNAUTHORIZED ,[
                'ERROR' => $e->getMessage()
            ]));
        }

    }



?>