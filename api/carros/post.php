<?php 

    include_once 'vendor/autoload.php';

    $person = new functions;


    if ($acao == '' && $param == ''){
        
        die($result = $person->createResponse(COD_ERROR_FOUND, PATH_NOT_FOUND,[
            ''
        ]));
    }

    switch ($acao)
    {
        case 'insert':
            break; 
        default:
            die($result = $person->createResponse(COD_ERROR_FOUND, ACTION_NOT_FOUND, ''));
    }

    if ($acao == 'insert')
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

        $name   = ucwords($data['name']);
        $brand  = ucwords($data['brand']);
        $year   = $data['year'];
        $price  = $data['price'];
        $status = ucwords($data['status']);
          
        $db                 = DB::connect();        
        $valor_formatado    = number_format($price, 2, ',', '.');

        # $hash = base64_encode($nome .'#'. $sobrenome.'#'. $idade.'#'.$email.'#'.$senha.'#'.$telefone);
        $rs         = $db->prepare("INSERT INTO cars (name, brand, year, price, status) VALUES ('$name', '$brand', '$year', '$valor_formatado', '$status')");

        try {
            $rs->execute();
            $id = $db->lastInsertId();
            $dados = [
                'id'        => $id,
                'name'      => $name,
                'brand'     => $brand,
                'year'      => $year,
                'price'     => $valor_formatado,
                'status'    => $status
            ];

            die($result = $person->createResponse(COD_SUCCESS,CAR_INSERTED ,[
                'dados' => $dados
            ]));
        }catch (Exception $e){
            die($result = $person->createResponse(COD_ERROR, ERROR_CAR_INSERTED ,[
                'ERROR' => $e->getMessage()
            ]));
        }
    
    }

?>