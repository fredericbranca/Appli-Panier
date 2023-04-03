<?php

    function sumQtt()
    {
        $qtt=0;
        if (empty($_SESSION['products'])){
            return 0;
        }
        else{
            foreach($_SESSION['products'] as $products){
                $qtt += $products["qtt"];
            }
            return $qtt;
            }
    }
