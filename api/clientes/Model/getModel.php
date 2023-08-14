<?php 

include_once 'vendor/autoload.php';

    class getModel {

        public function getUser($id)
        {
            $db = DB::connect();

            $sql = "SELECT * FROM users
                        WHERE id = '$id' ";

            $rs = $db->prepare($sql);

            try {
                $rs->execute();
                $obj = $rs->fetchObject();

                if ($obj)
                {
                    return [
                        'STATUS' => 'OK',
                        'FOUND'  => 'TRUE',
                        'DADOS'  => $obj
                    ];
                } else {
                    return [
                        'STATUS' => 'OK',
                        'FOUND'  => 'FALSE'
                    ];
                }

            }catch (Exception $e) {
                return [
                    'STATUS' => 'NOK',
                    'MSG'  => $e->getMessage()
                ];
            }
        }
    }

?>