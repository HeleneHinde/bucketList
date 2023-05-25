<?php

namespace App\Tools;

use phpDocumentor\Reflection\Types\Array_;

class Censurator
{
    private $offense=[ 'trompette', 'trouduc','saperlipopette'];
    public function purify (string $string):string{


        foreach ($this->offense as $fword) {

            $i = strlen($fword);
            $value=str_repeat('*',$i);
            $string = str_ireplace($fword, $value, $string);

        }
        /*$array = explode(' ',$string);

        foreach ($array as &$value){
            foreach ($this->offense as $fword){

                if ($value==$fword){

                    $i = strlen($value);

                    $value=str_repeat('*',$i);
                    break;
                }

            }

        }
        $string=implode(' ',$array);*/

        return $string;


    }


}