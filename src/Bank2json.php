<?php

namespace Bank2json;

use Carbon\Carbon;
use stdClass;

class Bank2json
{
    public static function readData($bank, $filename){
        $bank->read($filename);
        return $bank->data();
    }

}
