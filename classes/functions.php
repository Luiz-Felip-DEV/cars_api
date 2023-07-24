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

    }

?>