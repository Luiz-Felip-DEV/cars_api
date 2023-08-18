<?php 

include_once 'vendor/autoload.php';

class updateCarsModel {
        
    public function updateCar(array $arrDados)
    {
        $db = DB::connect();

        $id     = $arrDados['id'];
        $name   = ucwords($arrDados['name']);
        $brand  = ucwords($arrDados['brand']);
        $year   = $arrDados['year'];
        $price  = number_format($arrDados['price'], 2, ',', '.');
        $status = ucwords($arrDados['status']);

        $sql = "UPDATE cars SET 
                name = '$name', brand = '$brand', year = '$year', price = '$price', status = '$status'
                    WHERE id = '$id' ";
        
        $rs = $db->prepare($sql);

        try {
            $rs->execute();

            $dados = [
                'id'         => $id,
                'name'       => $name,
                'brand'      => $brand,
                'year'       => $year,
                'price'      => $price,
                'status'     => $status
            ];

            if ($rs->rowCount() > 0)
                {
                    return [
                        'STATUS'     => 'OK',
                        'UPDATE'     => 'TRUE',
                        'DADOS'      => $dados
                    ];
                }

                return [
                    'STATUS' => 'OK',
                    'UPDATE' => 'FALSE'
                ];
                
        } catch (Exception $e) {
            return [
                'STATUS' => 'NOK',
                'MSG'    => $e->getMessage()
            ];
        }
    }

    public function updateStatus(array $arrDados)
    {
        $db = DB::connect();

        $id     = $arrDados['id'];
        $status = ucwords($arrDados['status']);

        $sql = "UPDATE cars SET 
                status = '$status'
                    WHERE id = '$id' ";
                    
        $rs = $db->prepare($sql);

        try {
            
            $rs->execute();

            $dados = [
                'id'         => $id,
                'status'     => $status
            ];

            if ($rs->rowCount() > 0)
                {
                    return [
                        'STATUS'     => 'OK',
                        'UPDATE'     => 'TRUE',
                        'DADOS'      => $dados
                    ];
                }

                return [
                    'STATUS' => 'OK',
                    'UPDATE' => 'FALSE'
                ];
            
        } catch (Exception $e) {
            return [
                'STATUS' => 'NOK',
                'MSG'    => $e->getMessage()
            ];
        }
        
    }
}

?>