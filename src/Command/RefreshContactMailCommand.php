<?php

namespace App\Command;

use App\Entity\Lead;
use App\Repository\LeadRepository;
use App\Services\saveLeadService;
use LearnyBox\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshContactMailCommand extends Command
{

    private $leadRepository;
    private $saveLeadService;
    protected static $defaultName = 'app:refresh-contact';

    public function __construct(LeadRepository $leadRepository, saveLeadService $saveLeadService)
    {
        $this->leadRepository = $leadRepository;
        $this->saveLeadService = $saveLeadService;
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = Client::create([
            'api_key' => 'fdatfECqdfkGcjirnCBsmujGpgGvqFkDb',
            'subdomain' => 'affiliation-ninja'
        ]);

        $total = $client->get('mail/contacts')->{'total'};
        $count = $this->leadRepository->countLead();

        $leads = $client->get('mail/contacts?limit=' . $total . '&offset=' . $count[0]['1']);
        $increment = $total - $count[0]['1'];

        if($count[0]['1'] !== $total){
            for ($i = 0; $i < $increment; $i++) {
                $lead = new Lead();

                $lead->setEmail($leads->{'data'}[$i]->{'email'});
                $lead->setFirstName($leads->{'data'}[$i]->{'prenom'});
                $lead->setLastName($leads->{'data'}[$i]->{'nom'});
                $lead->setIdContact($leads->{'data'}[$i]->{'id_contact'});

                $this->saveLeadService->saveLead($lead);

            }
        }

        return Command::SUCCESS;
    }

}
