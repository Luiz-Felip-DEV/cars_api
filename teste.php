<?php 

    // $idade = 20030909;

    // $dataAtual = date('Ymd');

    // $teste = substr($dataAtual, 0, 4);  

    // // echo $teste;
    // // echo uniqid();



    $userBirthdate = "2003-04-22"; // Data de nascimento no formato "20030909"

    $anoFormatado = str_replace('-', '', $userBirthdate);

    // echo $anoFormatado;
    // exit;

    // Convertendo a data para o formato de data do PHP (Y-m-d)
    $formattedBirthdate = date_create_from_format('Ymd', $userBirthdate)->format('Y-m-d');

    // Criando objetos de data
    $birthDateObj = date_create($formattedBirthdate);
    $currentDateObj = date_create();

    // Calculando a diferença entre as datas
    $interval = date_diff($birthDateObj, $currentDateObj);

    // Obtendo a idade do usuário a partir do intervalo
    $age = $interval->format('%y');

    echo "O usuário tem $age anos.";
 



?>