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
                'key' =>  uniqid()
            ];
            $payload = json_encode($payload);
            $payload = base64_encode($payload);
        
            $chave = JWT_KEY;
            
            $assinatura = hash_hmac('sha256', "$header.$payload", $chave, true);

            
            $assinatura = base64_encode($assinatura);
        
            $JWT = "$header.$payload.$assinatura";

            return $JWT;
        }

        public function validateJWT($token)
        {

            $arrParams = explode('.', $token);

            $header     = $arrParams[0];
            $payload    = $arrParams[1];
            $assinatura = $arrParams[2];

            $validar = hash_hmac('sha256', "$header.$payload", JWT_KEY, true);

            $validar = base64_encode($validar);

            if ($assinatura == $validar)
            {
                $dados_token = base64_decode($payload);
                $dados_token = json_decode($dados_token);

                if ($dados_token->exp > time())
                {
                    return true;
                }

                return false;
            }
        }
    }

?>