<?php

namespace Bank2json;

class Bank2json
{
    public static function readData($bank, $filename){
        $bank->read($filename);
        return $bank->data();
    }

}
