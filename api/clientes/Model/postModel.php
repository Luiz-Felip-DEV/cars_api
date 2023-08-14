<?php 

include_once 'vendor/autoload.php';

    class postModel {


        public function insertUser(array $arrDados)
        {
            $db        = DB::connect();

            $name      = $arrDados['name'];
            $last_name = $arrDados['last_name'];
            $birth     = $arrDados['birth_date'];
            $email     = $arrDados['email'];
            $password  = $arrDados['password'];
            $telephone = $arrDados['telephone'];

            $sql = "INSERT INTO users 
                        (name, last_name, birth_date, email, password, telephone)
                    VALUES
                        ('$name', '$last_name', '$birth', '$email', '$password', '$telephone')";

            $rs         = $db->prepare($sql);

            try {
                $rs->execute();
                return [
                    'STATUS'        => 'OK',
                    'id'            => $db->lastInsertId(),
                    'name'          => $name,
                    'last_name'     => $last_name,
                    'birth_date'    => $birth,
                    'email'         => $email,
                    'password'      => $password,
                    'telephone'     => $telephone
                ];
            } catch (Exception $e){

                return [
                    'STATUS' => 'NOK',
                    'MSG' => $e->getMessage()
                ];
            }  
        }

        public function loginUser(array $arrDados)
        {
            $db       = DB::connect();

            $email      = $arrDados['email'];
            $password   = $arrDados['password'];

            $sql = "SELECT * FROM users 
                        WHERE email = '$email' AND
                              password = '$password' ";

            $rs         = $db->prepare($sql);


            try {

                $rs->execute();
                $obj = $rs->fetchObject();

                if ($obj)
                {
                    $arrUser = [
                        'STATUS' => 'OK',
                        'AUTHORIZATION' => 'TRUE',
                        'DADOS' => $obj
                    ];
                } else {
                    $arrUser = [
                        'STATUS' => 'OK',
                        'AUTHORIZATION' => 'FALSE'
                    ];
                }
                
                return $arrUser;
            } catch (Exception $e) {
                return [
                    'STATUS' => 'NOK',
                    'MSG' => $e->getMessage()
                ];
            }


        }
    }


?>