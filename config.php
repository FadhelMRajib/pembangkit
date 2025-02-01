<?php 

    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "db_pembangkit";

    $connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    $config['base_url'] = 'http://localhost/Pembangkit/';

    if(!$connection){
        echo "Koneksi keDatabase gagal" . mysqli_connect_error();
    }


    function base_url($url = null)
    {
        $base_url = 'http://localhost/Pembangkit';
        if($url != null){
            return $base_url . '/' .$url;
        }else{
            return $base_url;
        }
    }

