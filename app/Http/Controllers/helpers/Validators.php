<?php

namespace App\Http\Controllers\helpers;

trait Validators
{
   public function validatePhoneNumber($phone_number): bool
   {
       if(
            preg_match("/^[0-9]+$/", $phone_number) === 1 &&
            strlen($phone_number) > 10 &&
            is_numeric($phone_number)
       ) {
            return true;
       }
       return false;
   }


   public function validateUsername($username): bool
   {
       if ( strpos($username[0],"@") === 0 && strlen($username) > 4 ){
           return true;
       }
       return false;
   }


}
