<?php 

    include_once 'vendor/autoload.php';
    
    $person = new functions;
    $jwt    = new JWT;

    $authorizationr     = $_SERVER['HTTP_AUTHORIZATION'];

    if (empty($authorizationr))
    {
        die($person->createResponse(ACCESS_DENIED, TOKEN_NOT_FOUND, ''));
    }

    $arrToken           = explode(' ', $authorizationr);
    $token              = $arrToken[1];

    if (!$jwt->validateJWT($token))
    {
        die($person->createResponse(ACCESS_DENIED, TOKEN_NOT_FOUND, ''));
    }

    if ($acao == '' && $param == ''){
        die($person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
    }

    switch ($acao)
    {
        case 'update':
            break;
        case 'update-password':
            break;
        case 'update-telephone':
            break;
        case 'update-email':
            break;  
        default:
            die($person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }


    if ($acao == 'update')
        {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data)
            {
                $data = explode('#', base64_decode($_REQUEST['hash']));
            }   

            $id         = (isset($data['id']))                  ? $data['id']         : $data[0];
            $name       = ucwords((isset($data['name']))        ? $data['name']       : $data[1]); 
            $lastName   = ucwords((isset($data['last_name']))   ? $data['last_name']  : $data[2]);
            $birthDate  = (isset($data['birth_date']))          ? $data['birth_date'] : $data[3];
            $email      = (isset($data['email']))               ? $data['email']      : $data[4];
            $password   = (isset($data['password']))            ? $data['password']   : $data[5];
            $telephone  = $person->formatedNumber((isset($data['telephone'])) ? $data['telephone']  : $data[6]);
            $newDate    = date("Y-m-d", strtotime($birthDate));             
        
            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET name = '$name', last_name = '$lastName', birth_date = '$newDate', email = '$email', password = '$password', telephone = '$telephone' WHERE id = '$id'");
            try {
                $rs->execute();
                
                if ($rs->rowCount() > 0) 
                {
                    $dados = [
                        'id'            => $id,
                        'name'          => $name,
                        'last_name'     => $lastName,
                        'birth_date'    => $newDate,
                        'email'         => $email,
                        'password'      => $password,
                        'telefone'      => $telephone
                    ];

                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA,[
                        'dados' => $dados
                    ]));
                    
                } else {
                    die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,''));
                }

            } catch (Exception $e) {
                die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }

        if ($acao == 'update-password')
        {

            $data = json_decode(file_get_contents('php://input'), true); 

            if (!$data)
            {
                $data = explode('#', base64_decode($_REQUEST['hash']));
            }

            if (!$person->allFieldsFilled($data) || !$data)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                    ''
                ]));
            }


            $id         = (isset($data['id']))           ? $data['id'] : $data[0];
            $passAnti   = (isset($data['old_password'])) ? $data['old_password'] : $data[1];     
            $passNovo   = (isset($data['new_password'])) ? $data['new_password'] : $data[2];

            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET password = '$passNovo' WHERE id = '$id' AND password = '$passAnti' ");
            
            try {
                $rs->execute();

                if ($rs->rowCount() > 0) {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA, ''));
                }else{
                    die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
                }
                    
            }catch (Exception $e) {
                die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                    'ERROR' => $e->getMessage()
                ]));
            }
        }

        if ($acao == 'update-email')
        {
            $data = json_decode(file_get_contents('php://input'), true); 

            if (!$data)
            {
                $data = explode('#', base64_decode($_REQUEST['hash']));
            }

            if (!$person->allFieldsFilled($data) || !$data)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                    ''
                ]));
            }

            $id             = (isset($data['id']))        ? $data['id']        : $data[0];
            $emailAnti      = (isset($data['old_email'])) ? $data['old_email'] : $data[1];     
            $emailNovo      = (isset($data['new_email'])) ? $data['new_email'] : $data[2];

            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET email = '$emailNovo' WHERE id = '$id' AND email = '$emailAnti' ");

            try {
                $rs->execute();

                if ($rs->rowCount() > 0) {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA, ''));
                }else{
                    die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
                }
                    
            }catch (Exception $e) {
                die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                    'ERROR' => $e->getMessage()
                ]));
            }
        }

        if ($acao == 'update-telephone')
        {

            $data = json_decode(file_get_contents('php://input'), true); 

            if (!$data)
            {
                $data = explode('#', base64_decode($_REQUEST['hash']));
            }

            if (!$person->allFieldsFilled($data) || !$data)
            {
                die($person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                    ''
                ]));
            }

            $id                 = (isset($data['id']))            ? $data['id']            : $data[0];
            $telephoneAnti      = (isset($data['old_telephone'])) ? $data['old_telephone'] : $data[1];     
            $telephoneNovo      = (isset($data['new_telephone'])) ? $data['new_telephone'] : $data[2];

            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET telephone = '$telephoneNovo' WHERE id = '$id' AND email = '$telephoneAnti' ");

            try {
                $rs->execute();

                if ($rs->rowCount() > 0) {
                    die($person->createResponse(COD_SUCCESS, UPDATED_DATA, ''));
                }else{
                    die($person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
                }
                    
            }catch (Exception $e) {
                die($person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }



?>