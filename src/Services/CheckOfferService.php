<?php

namespace App\Services;

use App\Repository\OfferRepository;

class CheckOfferService
{
    private $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function checkOffer($name){

        $offer = $this->offerRepository->findOneBy(['name' => $name]);

        return $offer;
    }
}