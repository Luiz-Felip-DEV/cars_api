<?php 

    class functions {

        public function createResponse($status_code,$mensagem, $resp){
            http_response_code($status_code);
    
            header('Content-Type: application/json');
    
            $response = array (
                'status_code'   => $status_code,
                'msg'           => $mensagem,
                'resp'          => $resp 
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

    }

?>