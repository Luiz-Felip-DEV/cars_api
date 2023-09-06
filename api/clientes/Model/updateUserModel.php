<?php 

include_once 'vendor/autoload.php';

    class updateUserModel {

        public function update(array $arrDados)
        {
            $db = DB::connect();

            $id         = $arrDados['id_user'];
            $name       = ucwords($arrDados['name']); 
            $lastName   = ucwords($arrDados['last_name']);
            $birthDate  = $arrDados['birth_date'];
            $email      = $arrDados['email'];
            $password   = $arrDados['password'];
            $telephone  = $arrDados['telephone'];
            $birthDate  = date("Y-m-d", strtotime($birthDate));     

            $sql = "UPDATE users SET 
                name = '$name', last_name = '$lastName', birth_date = '$birthDate', email = '$email', password = '$password', telephone = '$telephone'
                    WHERE id = '$id' ";
                    
            $rs = $db->prepare($sql);

            try {
                $rs->execute();

                $dados = [
                        'id_user'    => $id,
                        'name'       => $name,
                        'last_name'  => $lastName,
                        'birth_date' => $birthDate,
                        'email'      => $email,
                        'password'   => $password,
                        'telephone'  => $telephone
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

        public function updatePassword(array $arrDados)
        {
            $db = DB::connect();

            $id          = $arrDados['id_user'];
            $oldPassword = $arrDados['old_password'];     
            $newPassword = $arrDados['new_password'];

            $sql = "UPDATE users SET
                        password = '$newPassword' WHERE id = '$id'";
            
            $rs = $db->prepare($sql);

            try {
                $rs->execute();

                $dados = [
                    'old_password' => $oldPassword,
                    'new_password' => $newPassword
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

        public function updateEmail(array $arrDados)
        {
            $db = DB::connect();

            $id       = $arrDados['id_user'];
            $oldEmail = $arrDados['old_email'];
            $newEmail = $arrDados['new_email'];

            $dados = [
                'old_email'   => $oldEmail,
                'new_email'   => $newEmail
            ];

            $sql = "UPDATE users SET
                        email = '$newEmail' WHERE id = '$id' AND password = '$oldEmail'";

            $rs = $db->prepare($sql);

            try {
                $rs->execute();

                if ($rs->rowCount() > 0) {

                    return [
                        'STATUS' => 'OK',
                        'UPDATE' => 'TRUE',
                        'DADOS'  => $dados
                    ];
                }else{
                    return [
                        'STATUS' => 'OK',
                        'UPDATE' => 'FALSE'
                    ];
                }

            } catch (Exception $e) {
                return [
                    'STATUS' => 'NOK',
                    'MSG'    => $e->getMessage()
                ];
            }
        }

        public function updateTelephone(array $arrDados)
        {
            $db = DB::connect();

            $id                 = $arrDados['id_user'];
            $oldTelephone       = $arrDados['old_telephone'] ;    
            $newTelephone       = $arrDados['new_telephone'];

            $dados = [
                'old_telephone' => $oldTelephone,
                'new_telephone' => $newTelephone
            ];

            $sql = "UPDATE users SET
                        telephone = '$newTelephone' WHERE id = '$id' AND telephone = '$oldTelephone'";

            $rs = $db->prepare($sql);

            try {
                $rs->execute();

                if ($rs->rowCount() > 0) {

                    return [
                        'STATUS' => 'OK',
                        'UPDATE' => 'TRUE',
                        'DADOS'  => $dados
                    ];
                }else{
                    return [
                        'STATUS' => 'OK',
                        'UPDATE' => 'FALSE'
                    ];
                }
            } catch (Exception $e) {
                return [
                    'STATUS' => 'NOK',
                    'MSG'    => $e->getMessage()
                ];
            }
        }
    }

?>