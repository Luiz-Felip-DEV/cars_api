<?php 

include_once 'vendor/autoload.php';

class postCarsModel {
    
    public function insertCar(array $arrDados)
    {
        $db        = DB::connect();
        
        $name   = ucwords($arrDados['name']);
        $brand  = ucwords($arrDados['brand']);
        $year   = $arrDados['year'];
        $price  = number_format($arrDados['price'], 2, ',', '.');
        $status = ucwords($arrDados['status']);  
        
        $sql = "INSERT INTO cars 
                        (name, brand, year, price, status)
                    VALUES
                        ('$name', '$brand', '$year', '$price', '$status')";

        $rs         = $db->prepare($sql);

        try {
            $rs->execute();
            $dados = [
                'id'        => $db->lastInsertId(),
                'name'      => $name,
                'brand'     => $brand,
                'year'      => $year,
                'price'     => $price,
                'status'    => $status
            ];

            return [
                'STATUS'  => 'OK',
                'DADOS'   => $dados
            ]; 
            
        } catch (Exception $e) {
            return [
                'STATUS' => 'NOK',
                'MSG' => $e->getMessage()
            ];
        }
    }
}

?>