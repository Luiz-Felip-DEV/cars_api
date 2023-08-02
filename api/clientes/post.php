<?php

    include_once 'vendor/autoload.php';

    $person = new functions;

    if ($acao == '' && $param == ''){

        die($result = $person->createResponse(COD_ERROR, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'insert':
            break;  
        default:
            die($result = $person->createResponse(COD_ERROR, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'insert' && $param == '')
    {
        
        $dados = $_POST;

        if (!$person->allFieldsFilled($dados))
        {
            die($result = $person->createResponse(COD_ERROR, WRONG_PARAMETERS,[
                        ''              ]));
            
        }
        
        $db             = DB::connect();
        $name           = ucwords($dados['name']);
        $last_name      = ucwords($dados['last_name']);
        $birth_date     = $dados['birth_date'];
        $email          = $dados['email'];
        $password       = $dados['password'];
        $telephone      = $person->formatedNumber($dados['telephone']);

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