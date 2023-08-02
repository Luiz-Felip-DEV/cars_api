<?php 

    include_once 'vendor/autoload.php';

    $person = new functions;

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(COD_ERROR, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'delete':
            break; 
        default:
            die($result = $person->createResponse(COD_ERROR, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'delete')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($result = $person->createResponse(COD_ERROR, WRONG_PARAMETERS, ''));
        }
        
        $db         = DB::connect();
        $hash       = base64_decode($_REQUEST['hash']);

        $rs         = $db->prepare("DELETE FROM cars WHERE id = '$hash'");

        try {
            $rs->execute();

            if ($rs->rowCount() > 0)
            {
                die($result = $person->createResponse(COD_SUCCESS,DELETE_SUCCESS ,''));
            } else {
                die($result = $person->createResponse(COD_ERROR_BD,NOTHING_FOUND, ''));
            }

        }catch (Exception $e) {
            die($result = $person->createResponse(COD_ERROR,DELETE_UNAUTHORIZED ,[
                'ERROR' => $e->getMessage()
            ]));
        }

    }



?>