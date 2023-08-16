<?php 

include_once 'vendor/autoload.php';

    class deleteUserModel {

        public function deleteUser($id)
        {

            $db         = DB::connect();

            $sql = "DELETE FROM users
                        WHERE id = '$id' ";

            $rs = $db->prepare($sql);

            try {
                $rs->execute();

                if ($rs->rowCount() > 0)
                {
                    return [
                        'STATUS' => 'OK',
                        'DELETE'  => 'TRUE'
                    ];
                } else {
                    return [
                        'STATUS' => 'OK',
                        'DELETE'  => 'FALSE'
                    ];
                }

            } catch (Exception $e) {
                return [
                    'STATUS' => 'NOK',
                    'MSG'  => $e->getMessage()
                ];
            }
        }
    }

?>