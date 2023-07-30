<?php
include_once 'classes/functions.php';

$person = new functions;

    if ($acao == '' && $param == ''){

        die($result = $person->createResponse(500, 'Caminho não Encontrado!', ''));
    }

    if ($acao == 'insert' && $param == '')
    {

        $dados = $_POST;

        if (!$person->allFieldsFilled($dados))
        {
            die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                        ''              ]));
            
        }

        $db             = DB::connect();
        $name           = $dados['name'];
        $last_name      = $dados['last_name'];
        $birth_date     = $dados['birth_date'];
        $email          = $dados['email'];
        $password       = $dados['password'];
        $telephone      = $dados['telephone'];

        if (!$person->verifyEmail($email))
        {
            echo "email repetido";
            exit;
        }

        echo "email valido";
        exit;

        # $hash = base64_encode($nome .'#'. $sobrenome.'#'. $idade.'#'.$email.'#'.$senha.'#'.$telefone);
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
                'telefone'      => $telephone
            ];

             die($result = $person->createResponse(200,'Usuario Cadastrado com Sucesso!' ,[
                'dados' => $dados
            ]));
        }catch (Exception $e) {
            die($result = $person->createResponse(500,'Erro ao Cadastrar Usuario!' ,[
                'ERROR' => $e->getMessage()
            ]));
        }

    }


?>