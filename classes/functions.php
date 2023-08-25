<?php 

    class functions {

        public function createResponse($status_code,$mensagem, $resp){
            http_response_code($status_code);
    
            header('Content-Type: application/json');
    
            $response = array (
                'status_code'   => $status_code,
                'msg'           => $mensagem,
                'result'        => $resp 
            );
    
            return json_encode($response);
        }

        public function createResponseLogin($status_code,$mensagem, $jwt,$resp){
            http_response_code($status_code);
    
            header('Content-Type: application/json');
    
            $response = array (
                'status_code'   => $status_code,
                'msg'           => $mensagem,
                'jwt'           => $jwt,
                'result'        => $resp 
            );
    
            return json_encode($response);
        }

        public function formatedNumber($telefone)
        {
            $numeroSemFormatacao    = preg_replace("/[^0-9]/", "", $telefone);
            $numeroFormatado        = preg_replace("/(\d{2})(\d{5})(\d{4})/", "($1) $2-$3", $numeroSemFormatacao);

            return $numeroFormatado;
        }

        public function getID($email, $password)
        {
            $db = DB::connect();
            $rs = $db->prepare("SELECT id FROM users WHERE email = '{$email}' AND password = '{$password}'");

            $rs->execute();
            $obj = $rs->fetchObject();

            return $obj->id;
        }

        public function verifyEmail($email)
        {
            $db = DB::connect();
            $rs = $db->prepare("SELECT email FROM users WHERE email = '{$email}'");
            $rs->execute();
            $obj = $rs->fetchAll();
            
            $resp = (count($obj) !== 0) ? false : true;

            return $resp;
        }

        public function verifyTelephone($telefone)
        {
            $numeroFormatado = $this->formatedNumber($telefone);
    
            $db = DB::connect();
            $rs = $db->prepare("SELECT telephone FROM users WHERE telephone = '{$numeroFormatado}'");
            $rs->execute();
            $obj = $rs->fetchAll();

            $resp = (count($obj) !== 0) ? false : true;

            return $resp;
        }

        public function allFieldsFilled($array)
        {
            foreach ($array as $valor) {
                if (empty($valor)) {
                    return false;
                }
            }
            return true;
        }

        public function verifyAge($userBirthdate)
        {
            $yearFormated       = str_replace('-', '', $userBirthdate);
            $userBirthdate      = $yearFormated; 
            $formattedBirthdate = date_create_from_format('Ymd', $userBirthdate)->format('Y-m-d');
        
            $birthDateObj       = date_create($formattedBirthdate);
            $currentDateObj     = date_create();
        
            $interval           = date_diff($birthDateObj, $currentDateObj);
        
            $age                = $interval->format('%y');
            
            if ($age < 18)
            {
                return false;
            }
            return true;
        }

        public function imgSave($nomeArquivo,$folder,$file)
        {
            if (!$nomeArquivo || !$file)
            {
                return false;
            }

            $caminho = $folder.'/'.$nomeArquivo;
            if (file_put_contents($caminho, $file))
            {
                return true;
            }

            return false;
        }

        public function imgGet($caminho)
        {
            $hash = file_get_contents($caminho);
            
            if (!$hash)
            {
                return false;
            }   
            
            return $hash;
        }

        public function modifyHash($arrParams)
        {
            for($i = 0; $i < count($arrParams); $i++)
            {
                $arrParams[$i]['hash'] = $this->imgGet('img/'.$arrParams[$i]['path']);
                unset($arrParams[$i]['path']);
            }
            
            return $arrParams;
        }

    }

?>