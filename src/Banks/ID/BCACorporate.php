<?php

namespace Bank2json\Banks\ID;

use Carbon\Carbon;
use Bank2json\BankStatement;

class BCACorporate extends BankStatement {

    public function read(string $filename)
    {
        $this->filename = $filename;
        $file = fopen($this->filename, 'r');
        if ($file !== false) {
            $lineNumber = 1;
            while (($line = fgetcsv($file)) !== false) {
                if ($lineNumber == 3) {
                    // get the account number
                    // split and trim whitespace and get the number from a string like "No. rekening : 1111111111"
                    $this->account['number'] = trim(str_replace('No. rekening : ', '', $line[0]));
                }

                if ($lineNumber == 4) {
                    // get the account number
                    // split and trim whitespace and get the number from a string like "No. rekening : 1111111111"
                    $this->account['name'] = trim(str_replace('Nama : ', '', $line[0]));
                }

                if ($lineNumber == 5) {
                    // get the year as dates in transaction lines is not formatted with year
                    $transactionYear = substr(trim(str_replace('Periode : ','',$line[0])),6,4);
                }

                if ($lineNumber == 6) {
                    // get the currency
                    $this->account['currency'] = trim(str_replace('Kode Mata Uang : ','',$line[0]));
                }

                if($lineNumber > 7) {
                    if(substr($line[0],0,5) == 'Saldo'){
                        break;
                    }
                    // get the debit (DB) or credit (CR) indicator from line[3] using the last 2 characters of the string
                    $indicator = substr($line[3],-2);
                    $amount = (float) (str_replace([',',' ','DB','CR'], '', $line[3]));
                    $this->transactions[] = [
                        'date' => Carbon::parse($line[0] . '-' . $transactionYear)->format('Y-m-d'),
                        'description' => trim($line[1]),
                        'amount' => $amount * ($indicator == 'DB' ? -1 : 1),
                    ];
                }
                $lineNumber++;
            }
        }
        fclose($file);
        return $this;
    }
}
