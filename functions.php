<?php

    session_start();

    function sumQtt()
    {
        $qt=0;
        if (empty($_SESSION['products'])){
            return 0;
        }
        else{
            foreach($_SESSION['products'] as $s){
                $qt += $s["qtt"];
            }
            return $qt;
            }
    }
