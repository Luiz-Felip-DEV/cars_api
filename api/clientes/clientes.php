<?php 

    if ($api == 'users') 
    {
        if ($method == 'GET')
        {
            include_once 'Controller/getUserController.php';
        }

        if ($method == 'POST')
        {
            include_once 'Controller/postUserController.php';
        }

        if ($method == 'PUT')
        {
            include_once 'Controller/updateUserController.php';
        }

        if ($method == 'DELETE')
        {
            include_once 'Controller/deleteUserController.php';
        }
    }

?>