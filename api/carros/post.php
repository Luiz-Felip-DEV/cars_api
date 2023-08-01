<?php 

    include_once 'vendor/autoload.php';

    $person = new functions;


    if ($acao == '' && $param == ''){
        
        die($result = $person->createResponse(COD_ERROR, PATH_NOT_FOUND,[
            ''
        ]));
    }

    if ($acao == 'insert')
    {

        $dados = $_POST;

        if (!$person->allFieldsFilled($dados))
        {
            die($result = $person->createResponse(COD_ERROR, WRONG_PARAMETERS,[
                        ''              ]));
            
        }

        $name   = ucwords($dados['name']);
        $brand  = ucwords($dados['brand']);
        $year   = $dados['year'];
        $price  = $dados['price'];
        $status = ucwords($dados['status']);
          
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