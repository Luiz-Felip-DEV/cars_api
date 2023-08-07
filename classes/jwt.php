<?php 

    class jwt {

        public function gerarJWT()
        {
            
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT',
            ];
            $header = json_encode($header);
            $header = base64_encode($header);
        
            $duracao = time() + (24 * 60 * 60);
        
            $payload = [
                'iss' => 'localhost',
                'aud' => 'localhost',
                'exp' => $duracao,
            ];
            $payload = json_encode($payload);
            $payload = base64_encode($payload);
        
            $chave = JWT_KEY;
            
            $assinatura = hash_hmac('sha256', "$header.$payload", $chave, true);
        
            $assinatura = base64_encode($assinatura);
        
            $JWT = "$header.$payload.$assinatura";

            return $JWT;
        }
    }

?>