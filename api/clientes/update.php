<?php 

    include_once 'vendor/autoload.php';
    
    $person = new functions;

    if ($acao == '' && $param == ''){
        die($result = $person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND, ''));
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
            die($result = $person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }


    if ($acao == 'update')
        {
            if (!isset($_REQUEST['hash']))
            {
                die($result = $person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
                    ''
                ]));
            }
            $arrParams = explode('#', base64_decode($_REQUEST['hash']));


            $data = date("Y-m-d", strtotime($arrParams[3])); 
        
            $db = DB::connect();
            $rs = $db->prepare("UPDATE users SET name = '$arrParams[1]', last_name = '$arrParams[2]', birth_date = '$data', email = '$arrParams[4]', password = '$arrParams[5]', telephone = '$arrParams[6]' WHERE id = '$arrParams[0]'");
            try {
                $rs->execute();
                
                if ($rs->rowCount() > 0) 
                {
                    $dados = [
                        'id'            => $arrParams[0],
                        'name'          => $arrParams[1],
                        'last_name'     => $arrParams[2],
                        'dt_nascimento' => $data,
                        'email'         => $arrParams[4],
                        'password'      => $arrParams[5],
                        'telefone'      => $arrParams[6]
                    ];

                    die($result = $person->createResponse(COD_SUCCESS, UPDATED_DATA,[
                        'dados' => $dados
                    ]));
                    
                } else {
                    die($result = $person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,''));
                }

            } catch (Exception $e) {
                die($result = $person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
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
                die($result = $person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
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
                    die($result = $person->createResponse(COD_SUCCESS, UPDATED_DATA, ''));
                }else{
                    die($result = $person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
                }
                    
            }catch (Exception $e) {
                die($result = $person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
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
                die($result = $person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
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
                    die($result = $person->createResponse(COD_SUCCESS, UPDATED_DATA, ''));
                }else{
                    die($result = $person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
                }
                    
            }catch (Exception $e) {
                die($result = $person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
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
                die($result = $person->createResponse(COD_ERROR_PARAMETERS, WRONG_PARAMETERS,[
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
                    die($result = $person->createResponse(COD_SUCCESS, UPDATED_DATA, ''));
                }else{
                    die($result = $person->createResponse(COD_ERROR_BD, UPDATED_UNAUTHORIZED, ''));
                }
                    
            }catch (Exception $e) {
                die($result = $person->createResponse(COD_ERROR, UPDATED_UNAUTHORIZED,[
                    'ERROR' => $e->getMessage()
                ]));
            }

        }



?>