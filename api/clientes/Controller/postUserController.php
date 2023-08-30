<?php

    include_once 'vendor/autoload.php';

    $person = new functions;
    $jwt    = new JWT;
    $model  = new postUserModel;


    if ($acao == '' && $param == ''){

        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'insert':
            break;
        case 'login':
            break;
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'insert' && $param == '')
    {
        $arrData = $_POST;

        if (!$arrData)
        {
           $arrData = json_decode(file_get_contents('php://input'), true); 
        }

        if (!$person->allFieldsFilled($arrData) || !$arrData)
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,'')); 
        }
        
        $birth_date     = date("Y-m-d", strtotime($arrData['birth_date']));
        $email          = $arrData['email'];
        $telephone      = $person->formatedNumber($arrData['telephone']);

        if ($person->verifyEmail($email))
        {
            die($person->createResponse(REPEATED_DATA_BANK, EMAIL_IS_ALREADY_DATABASE, ''));
        }

        if (!$person->verifyTelephone($telephone))
        {
            die($person->createResponse(REPEATED_DATA_BANK, TELEPHONE_IS_ALREADY_DATABASE, ''));
        }

        if (!$person->verifyAge($birth_date))
        {
            die($person->createResponse(REPEATED_DATA_BANK, AGE_NOT_ALLOWED, ''));
        } 

        $arrData['birth_date'] = date("Y-m-d", strtotime($birth_date));
        $arrData['telephone']  = $telephone;
        $arrData['password']   = password_hash($arrData['password'], PASSWORD_DEFAULT);

        $arrResult = $model->insertUser($arrData);

        if($arrResult['STATUS'] == 'OK')
        {

            $dados = [
                'id'            => $arrResult['id'],
                'name'          => $arrResult['name'],
                'last_name'     => $arrResult['last_name'],
                'birth_date'    => $arrResult['birth_date'],
                'email'         => $arrResult['email'],
                'password'      => $arrResult['password'],
                'telephone'     => $arrResult['telephone']
            ];

            die($person->createResponse(COD_SUCCESS, USER_REGISTERED_SUCCESS ,[
                'dados' => $dados
            ]));

        }
        
        die($person->createResponse(COD_ERROR, ERROR_REGISTER_USER ,[
            'ERROR' => $arrResult['MSG']
        ]));

    }

    if ($acao == 'login')
    {
        $arrData = $_POST;

        if (!$arrData)
        {
           $arrData = json_decode(file_get_contents('php://input'), true); 
        }

        $email      = $arrData['email'];

        if (!$person->verifyEmail($email))
        {
            die($person->createResponse(COD_ERROR_BD, EMAIL_NOT_EXISTS,''));
        }

        $password   = $arrData['password'];
        
        $arrResult  = $model->loginUser($arrData);

        if ($arrResult['STATUS'] == 'OK')
        {
            if ($arrResult['AUTHORIZATION'] == 'TRUE')
            {
                die($person->createResponseLogin(COD_SUCCESS, LOGIN_SUCCESS,$jwt->gerarJWT(),[
                    'dados'     => $arrResult['DADOS']
                ]));
            } else {
                die($person->createResponse(COD_ERROR_BD, LOGIN_UNAUTHORIZED,''));
            }
        } else {
            die($person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
                'ERROR' => $arrResult['MSG']
            ]));
        }
    }


?>