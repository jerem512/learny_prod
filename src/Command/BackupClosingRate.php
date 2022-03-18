<?php

namespace App\Command;

use App\Entity\ClosingRateBackup;
use App\Repository\ClosingRateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BackupClosingRate extends Command
{
    private $closingrateRepository;
    private $entityManager;

    protected static $defaultName = 'app:backup-closingrate';

    public function __construct(ClosingRateRepository $closingRateRepository, EntityManagerInterface $entityManager)
    {
        $this->closingrateRepository = $closingRateRepository;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $closingrates = $this->closingrateRepository->findAll();

        //dd($closingrates[0]->getDate());

        foreach($closingrates as $closingrate){
            $closingrateBackup = new ClosingRateBackup();

            $closingrateBackup->setUserId($closingrate->getUserId());
            $closingrateBackup->setDate($closingrate->getDate());
            $closingrateBackup->setFup($closingrate->getFup());
            $closingrateBackup->setShofup($closingrate->getShofup());
            $closingrateBackup->setBack($closingrate->getBack());
            $closingrateBackup->setClosefup($closingrate->getClosefup());
            $closingrateBackup->setLeads($closingrate->getLeads());
            $closingrateBackup->setLeadsValid($closingrate->getLeadsValid());
            $closingrateBackup->setLeadsContact($closingrate->getLeadsContact());
            $closingrateBackup->setLeadsOffer($closingrate->getLeadsOffer());
            $closingrateBackup->setLeadsFup($closingrate->getLeadsFup());
            $closingrateBackup->setLeadsClose($closingrate->getLeadsClose());
            $closingrateBackup->setLeadsConfirm($closingrate->getLeadsConfirm());

            $this->entityManager->persist($closingrateBackup);
            $this->entityManager->flush();

            $this->closingrateRepository->drop_table($closingrate->getId());

        }
        
        return Command::SUCCESS;
        
    }
}