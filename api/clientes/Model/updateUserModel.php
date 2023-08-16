<?php 

include_once 'vendor/autoload.php';

    class updateUserModel {

        public function update(array $arrDados)
        {
    
            $db = DB::connect();

            $id         = (isset($arrDados['id']))                  ? $arrDados['id']         : $arrDados[0];
            $name       = ucwords((isset($arrDados['name']))        ? $arrDados['name']       : $arrDados[1]); 
            $lastName   = ucwords((isset($arrDados['last_name']))   ? $arrDados['last_name']  : $arrDados[2]);
            $birthDate  = (isset($arrDados['birth_date']))          ? $arrDados['birth_date'] : $arrDados[3];
            $email      = (isset($arrDados['email']))               ? $arrDados['email']      : $arrDados[4];
            $password   = (isset($arrDados['password']))            ? $arrDados['password']   : $arrDados[5];

            $telephone = isset($arrDados['telephone']) ? $arrDados['telephone']  : $arrDados[6];
            $newDate    = date("Y-m-d", strtotime($birthDate));     

            $sql = "UPDATE users SET 
                name = '$name', last_name = '$lastName', birth_date = '$birthDate', email = '$email', password = '$password', telephone = '$telephone'
                    WHERE id = '$id' ";
                    
            $rs = $db->prepare($sql);

            try {
                $rs->execute();

                $dados = [
                        'id'         => $id,
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

            $id          = (isset($arrDados['id']))           ? $arrDados['id'] : $arrDados[0];
            $oldPassword = (isset($arrDados['old_password'])) ? $arrDados['old_password'] : $arrDados[1];     
            $newPassword = (isset($arrDados['new_password'])) ? $arrDados['new_password'] : $arrDados[2];

            $sql = "UPDATE users SET
                        password = '$newPassword' WHERE id = '$id' AND password = '$oldPassword'";
            
            $rs = $db->prepare($sql);

            try {
                $rs->execute();

                $dados = [
                    'id'           => $id,
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

            $id       = $arrDados['id'];
            $oldEmail = $arrDados['old_email'];
            $newEmail = $arrDados['new_email'];

            $dados = [
                'id'          => $id,
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

            $id                 = $arrDados['id'];
            $oldTelephone       = $arrDados['old_telephone'] ;    
            $newTelephone       =  $arrDados['new_telephone'];

            $dados = [
                'id'            => $id,
                'old_telephone' => $oldTelephone,
                'new_telephone' => $newTelephone
            ];

            $sql = "UPDATE users SET
                        telephone = '$newTelephone' WHERE id = '$id' AND password = '$oldTelephone'";

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