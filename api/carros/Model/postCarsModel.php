<?php 

include_once 'vendor/autoload.php';

class postCarsModel {
    
    public function insertCar(array $arrDados)
    {
        $db        = DB::connect();
        $fc        = new functions;
        
        $name   = ucwords($arrDados['name']);
        $brand  = ucwords($arrDados['brand']);
        $year   = $arrDados['year'];
        $price  = number_format($arrDados['price'], 2, ',', '.');
        $status = ucwords($arrDados['status']); 
        $hash   = (!$arrDados['hash'] || !isset($arrDados['hash']) ) ? '' : $arrDados['hash'];
        $path   = '';

        if($hash)
        {
            $path = trim(date('Y_m_d').'_'.$name.'_'.$brand.'.txt');
        }
        
        $sql = "INSERT INTO cars 
                        (name, brand, year, price, status, path)
                    VALUES
                        ('$name', '$brand', '$year', '$price', '$status', '$path')";

        $rs         = $db->prepare($sql);

        try {
            $rs->execute();
            $dados = [
                'id'        => $db->lastInsertId(),
                'name'      => $name,
                'brand'     => $brand,
                'year'      => $year,
                'price'     => $price,
                'status'    => $status,
                'path'      => $path
            ];
            if ($hash)
            {
                $folder = 'img';
                if (!$fc->imgSave($path, $folder, $hash))
                {
                    return [
                        'STATUS' => 'NOK',
                        'MSG'    => 'ERRO AO INSERIR IMAGEM'
                    ];
                }


            }

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