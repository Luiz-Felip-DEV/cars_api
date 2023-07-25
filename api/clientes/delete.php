<?php 

include_once 'classes/functions.php';

$person = new functions;

    if ($acao == '' && $param == ''){
        echo json_encode(['ERRO' => 'Caminho não encontrado']);
    }

    if ($acao == 'delete' && $param == '')
    {
        if (!isset($_REQUEST['hash']))
        {
            die($result = $person->createResponse(500, 'Parametros Incorretos!',[
                ''
            ]));
        }
        
        $db         = DB::connect();
        $hash       = base64_decode($_POST['hash']);

        $rs         = $db->prepare("DELETE FROM users WHERE id = '$hash'");
        $rs->execute();

        die($result = $person->createResponse(200,'Usuario Deletado com Sucesso!' ,[
            ''
        ]));
    }

?>