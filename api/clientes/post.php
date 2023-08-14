<?php

    include_once 'vendor/autoload.php';

    $person = new functions;
    $jwt    = new JWT;


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
        $data = $_POST;

        if (!$data)
        {
           $data = json_decode(file_get_contents('php://input'), true); 
        }

        if (!$person->allFieldsFilled($data) || !$data)
        {
            die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
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


            die($person->createResponse(COD_SUCCESS, USER_REGISTERED_SUCCESS ,[
                'dados' => $dados
            ]));
        }catch (Exception $e) {
            die($person->createResponse(COD_ERROR, ERROR_REGISTER_USER ,[
                'ERROR' => $e->getMessage()
            ]));
        }   

    }

    if ($acao == 'login')
    {
        $data = $_POST;

        if (!$data)
        {
           $data = json_decode(file_get_contents('php://input'), true); 
        }

        $email      = $data['email'];
        $password   = $data['password'];
        
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM users WHERE email = '$email' AND password = '$password' ");
        try {
            $rs->execute();
            $obj = $rs->fetchObject();  

            if ($obj) 
            {
                die($person->createResponse(COD_SUCCESS, LOGIN_SUCCESS,[
                    'jwt'       => $jwt->gerarJWT(),
                    'dados'     => $obj
                ]));
            }else {
                die($person->createResponse(COD_ERROR_BD, LOGIN_UNAUTHORIZED,[
                    ''
                ]));
            }
        } catch (Exception $e) {
            die($person->createResponse(COD_ERROR, ERROR_SEARCH_DATA,[
                'ERROR' => $e->getMessage()
            ]));
        }
    }


?>