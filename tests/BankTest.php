<?php

use Bank2json\Banks\ID\BCACorporate;

it('test bca with file', function(){
    $bca = new BCACorporate();
    $data = $bca->read(__DIR__.'/../files/ID_bcabusiness.csv')->data();
    expect($data)->toBeArray()
        ->and($data['account']['number'])->toBe('1111111111')
        ->and($data['transactions'])->not()->toBeEmpty()
        ;
});
