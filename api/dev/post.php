<?php 

include_once 'vendor/autoload.php';

$person = new functions;
$jwt    = new JWT;


    if ($acao == '' && $param == ''){

        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'BRING-JWT-TOKEN':
            break;  
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'BRING-JWT-TOKEN')
    {
        $dados = [
            "jwt" => $jwt->gerarJWT()
        ];

        die($person->createResponse(COD_SUCCESS, JWT_SUCCESS, $dados));
    }      

?>