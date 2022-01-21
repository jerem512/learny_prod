<?php

namespace App\Services;

use App\Repository\NumberSurtaxeRepository;

class CheckTaxNumberService
{
    private $numberSurtaxeRepository;

    public function __construct(NumberSurtaxeRepository $numberSurtaxeRepository)
    {
        $this->numberSurtaxeRepository = $numberSurtaxeRepository;
    }

    public function checkTaxNumber($lead_number){
        $format_number = explode(" ", $lead_number);
        $indicative = $format_number[0];
        $isNumber = strpos($indicative, '+');
        
        if($isNumber !== false){
            $match = $this->numberSurtaxeRepository->findOneBy(['indicative' => $indicative])->getIsSurtaxed();   
        }else{
            $match = "NaN";
        }

        return $match;
    }

    public function isNumber($block_call){

        $NaN  = false;

        if(is_string($block_call) && $block_call == "NaN"){
            $NaN = true;
        }else{
            $NaN  = false;
        }

        return $NaN;
    }
}