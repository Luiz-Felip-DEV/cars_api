<?php

    include_once 'vendor/autoload.php';

    $person = new functions;
    $jwt    = new JWT;

    // $authorizationr     = $_SERVER['HTTP_AUTHORIZATION'];

    // if (empty($authorizationr))
    // {
    //     die($person->createResponse(ACCESS_DENIED, TOKEN_NOT_FOUND, ''));
    // }

    // $arrToken           = explode(' ', $authorizationr);
    // $token              = $arrToken[1];

    // if (!$jwt->validateJWT($token))
    // {
    //     die($person->createResponse(ACCESS_DENIED, TOKEN_NOT_FOUND, ''));
    // }


    if ($acao == '' && $param == ''){

        die($result = $person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'insert':
            break;
        default:
            die($result = $person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'insert' && $param == '')
    {
        $data = $_POST;

        if (!$data)
        {
           $data = json_decode(file_get_contents('php://input'), true); 
        }

        if (!$person->allFieldsFilled($data) || !$data)
        {
            die($result = $person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                        ''              ])); 
        }
        
        $db             = DB::connect();
        $name           = ucwords($data['name']);
        $last_name      = ucwords($data['last_name']);
        $birth_date     = $data['birth_date'];
        $email          = $data['email'];
        $password       = $data['password'];
        $telephone      = $person->formatedNumber($data['telephone']);

        if (!$person->verifyEmail($email))
        {
            die($result = $person->createResponse(REPEATED_DATA_BANK, EMAIL_IS_ALREADY_DATABASE, ''));
        }

        if (!$person->verifyTelephone($telephone))
        {
            die($result = $person->createResponse(REPEATED_DATA_BANK, TELEPHONE_IS_ALREADY_DATABASE, ''));
        }

        $data = date("Y-m-d", strtotime($birth_date)); 

        $rs         = $db->prepare("INSERT INTO users (name, last_name, birth_date, email, password, telephone) VALUES ('$name', '$last_name', '$data', '$email', '$password', '$telephone')");


        try {
            $rs->execute();
            $id = $db->lastInsertId();
            
            $dados = [
                'id'            => $id,
                'name'          => $name,
                'last_name'     => $last_name,
                'dt_nascimento' => $data,
                'email'         => $email,
                'password'      => $password,
                'telephone'     => $telephone
            ];


            die($result = $person->createResponse(COD_SUCCESS, USER_REGISTERED_SUCCESS ,[
                'dados' => $dados
            ]));
        }catch (Exception $e) {
            die($result = $person->createResponse(COD_ERROR, ERROR_REGISTER_USER ,[
                'ERROR' => $e->getMessage()
            ]));
        }   

    }


?>