<?php 

    if ($api == 'users') 
    {
        if ($method == 'GET')
        {
            include_once 'Controller/getController.php';
        }

        if ($method == 'POST')
        {
            include_once 'Controller/postController.php';
        }

        if ($method == 'PUT')
        {
            include_once 'Controller/updateController.php';
        }

        if ($method == 'DELETE')
        {
            include_once 'Controller/deleteController.php';
        }
    }

?>