<?php 

include_once 'vendor/autoload.php';

class postCarsModel {
    
    public function insertCar(array $arrDados)
    {
        $db        = DB::connect();
        
        $name   = ucwords($arrDados['name']);
        $brand  = ucwords($arrDados['brand']);
        $year   = $arrDados['year'];
        $price  = $arrDados['price'];
        $status = ucwords($arrDados['status']);

        $price  = number_format($price, 2, ',', '.');   
        
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