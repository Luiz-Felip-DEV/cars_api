<?php 

if ($api == 'cars') 
{
    if ($method == 'GET')
    {
        include_once 'Controller/getCarsController.php';
    }

    if ($method == 'POST')
    {
        include_once 'Controller/postCarsController.php';
    }

    if ($method == 'PUT')
    {
        include_once 'Controller/updateCarsController.php';
    }

    if ($method == 'DELETE')
    {
        include_once 'Controller/deleteCarsController.php';
    }
}

?>