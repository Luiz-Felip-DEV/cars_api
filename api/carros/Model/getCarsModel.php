<?php 

include_once 'vendor/autoload.php';

class getCarsModel {
    
    public function getCars()
    {
        $db = DB::connect();

        $sql = "SELECT * FROM cars ORDER BY brand";

        $rs = $db->prepare($sql);

        try {
            $rs->execute();
            $arrReturnDados = $rs->fetchAll(PDO::FETCH_ASSOC);

            if ($arrReturnDados)
            {
                return [
                    'STATUS' => 'OK',
                    'FOUND'  => 'TRUE',
                    'DADOS'  => $arrReturnDados
                ];
            }

            return [
                'STATUS' => 'OK',
                'FOUND'  => 'FALSE'
            ];
            
        } catch (Exception $e) {
            return [
                'STATUS' => 'NOK',
                'MSG'  => $e->getMessage()
            ];
        }
    }

    public function getCarsBrand($brand)
    {
        $db = DB::connect();

        $brand = ucwords($brand);

        $sql =  "SELECT * FROM cars
                    WHERE brand = '$brand'";

        $rs = $db->prepare($sql);

        try {
            
            $rs->execute();
            $arrReturnDados = $rs->fetchAll(PDO::FETCH_ASSOC);
            
            if ($arrReturnDados)
            {
                return [
                    'STATUS' => 'OK',
                    'FOUND'  => 'TRUE',
                    'DADOS'  => $arrReturnDados
                ];
            }

            return [
                'STATUS' => 'OK',
                'FOUND'  => 'FALSE'
            ];
            
        } catch (Exception $e) {
            return [
                'STATUS' => 'NOK',
                'MSG'  => $e->getMessage()
            ];
        }
    }

    public function getCarsId($id)
    {
        $db = DB::connect();

        $sql =  "SELECT * FROM cars
                    WHERE id = '$id'";

        $rs = $db->prepare($sql);

        try {
            
            $rs->execute();
            $arrReturnDados = $rs->fetchAll(PDO::FETCH_ASSOC);

            if ($arrReturnDados)
            {
                return [
                    'STATUS' => 'OK',
                    'FOUND'  => 'TRUE',
                    'DADOS'  => $arrReturnDados
                ];
            }

            return [
                'STATUS' => 'OK',
                'FOUND'  => 'FALSE'
            ];
            
        } catch (Exception $e) {
            return [
                'STATUS' => 'NOK',
                'MSG'  => $e->getMessage()
            ];
        }

        
        
    }
}

?>