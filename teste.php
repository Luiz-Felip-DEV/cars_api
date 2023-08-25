<?php 



    // $curl = curl_init();
    // $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjb2RQZXNzb2EiOiI2MDAwMzA3ODkifQ.1Pat7MoIJdXYbZ9jOprI9_snHmMxzPwP38dsBPuL9E4';

    // $headr[] = 'Authorization: Baerer '.$token;
    // $urlApi = 'http://localhost/comum/upload-arquivo-hash';

    // $dados = [
    //     'nome_arquivo' => '814406_TCE_FRENTE',
    //     'bucket'       => 'acervo_digital',
    //     'folder'       => 'pessoa-fisica/doc-academica/600851727',
    //     'hash'         => 'dsadsasaddsa'
    // ];

    // curl_setopt_array($curl, array(
    //     CURLOPT_RETURNTRANSFER 	=> TRUE,
    //     CURLOPT_URL 			=> $urlApi,
    //     CURLOPT_HTTPHEADER 		=> $headr,
    //     CURLOPT_POSTFIELDS 		=> $dados
    // ));
    // $retorno = curl_exec($curl);
    // $response = json_decode($retorno);

    // print_r($response);
    // exit;

    // $text = 'NEcóSDANI';

    // $nov = str_replace('', 'Ó', $text);

    // $npva = strtoupper($text);

    // echo $npva;

    // class teste {


    //     function strtoupper_with_accents($string) {
    //         $map = array(
    //             'à' => 'À', 'á' => 'Á', 'â' => 'Â', 'ã' => 'Ã', 'ä' => 'Ä',
    //             'è' => 'È', 'é' => 'É', 'ê' => 'Ê', 'ë' => 'Ë',
    //             'ì' => 'Ì', 'í' => 'Í', 'î' => 'Î', 'ï' => 'Ï',
    //             'ò' => 'Ò', 'ó' => 'Ó', 'ô' => 'Ô', 'õ' => 'Õ', 'ö' => 'Ö',
    //             'ù' => 'Ù', 'ú' => 'Ú', 'û' => 'Û', 'ü' => 'Ü',
    //             'ç' => 'Ç'
    //         );
        
    //         $string = strtr($string, $map);
    //         $string = mb_strtoupper($string, 'UTF-8');
    //         return $string;
    //     } 
    // }

    // $tt = new teste();

    // $texto = 'NéCóSDANí';

    // echo $tt->strtoupper_with_accents($texto);

    $brand = base64_encode('toyota');

    echo $brand;






?>