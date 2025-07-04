<?php 

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
    //check if $value is encrypted
    public static function decryptId($value)
    {
    try {
         $value = Crypt::decrypt($value);
    } catch (DecryptException $e) {
         return null;
    }

      return $value;
    }
    
}