<?php

namespace App\Command;

use App\Entity\MemberNinja;
use App\Repository\MemberNinjaRepository;
use App\Services\ClientLearnyboxService;
use App\Services\saveLeadService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshMemberNinjaCommand extends Command
{

    private $saveLeadService;
    private $memberNinjaRepository;
    private $clientLearnyboxService;

    protected static $defaultName = 'app:refresh-member-ninja';

    public function __construct(ClientLearnyboxService $clientLearnyboxService, saveLeadService $saveLeadService, MemberNinjaRepository $memberNinjaRepository)
    {
        $this->clientLearnyboxService = $clientLearnyboxService;
        $this->saveLeadService = $saveLeadService;
        $this->memberNinjaRepository = $memberNinjaRepository;
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->clientLearnyboxService->clientLearnybox();

        $total = $client->get('formations/32341')->{'data'}->{'non_admin_users_count'};
       
        $count = $this->memberNinjaRepository->countMemberNinja();

        $members = $client->get('formations/32341/membres?limit=' . $total . '&offset=' . $count[0]['1']);
        //dd($members);
        $increment = $total - $count[0]['1'];
        
        if($count[0]['1'] !== $total){
            for ($i = 0; $i < $increment; $i++) {
                $member = new MemberNinja();
                
                $member->setLastName($members->{'data'}[$i]->{'user'}->{'lname'});
                $member->setFirstName($members->{'data'}[$i]->{'user'}->{'fname'});
                $member->setEmail($members->{'data'}[$i]->{'user'}->{'email'});
                $member->setDateCreation(date_format(new \DateTime($members->{'data'}[$i]->{'dateinscription'}), 'Y-m-d'));
                $member->setLeadId($members->{'data'}[$i]->{'user'}->{'user_id'});

                if($members->{'data'}[$i]->{'idgroupe'} == "21198"){
                    $member->setGroups('Groupe 1 (Accompagnement coaching terminé)');
                }elseif($members->{'data'}[$i]->{'idgroupe'} == "18388"){
                    $member->setGroups('Groupe 1 (Accompagnement)');
                }elseif($members->{'data'}[$i]->{'idgroupe'} == "21196"){
                    $member->setGroups('Groupe 2 (Premium coaching terminé)');
                }elseif($members->{'data'}[$i]->{'idgroupe'} == "19486"){
                    $member->setGroups('Groupe 2 (Premium)');
                }elseif($members->{'data'}[$i]->{'idgroupe'} == "33551"){
                    $member->setGroups('Groupe 3 (starter)');
                }elseif($members->{'data'}[$i]->{'idgroupe'} == "18388,21198"){
                    $member->setGroups('Groupe 1 (Accompagnement) - Groupe 1 (Accompagnement coaching terminé)');
                }elseif($members->{'data'}[$i]->{'idgroupe'} == "21196,21198"){
                    $member->setGroups('Groupe 2 (Premium coaching terminé) - Groupe 1 (Accompagnement coaching terminé)');
                }elseif($members->{'data'}[$i]->{'idgroupe'} == "21196,19486"){
                    $member->setGroups('Groupe 2 (Premium coaching terminé) - Groupe 2 (Premium)');
                }elseif($members->{'data'}[$i]->{'idgroupe'} == "0"){
                    $member->setGroups('');
                }else{
                    $member->setGroups('');
                }

                $this->saveLeadService->saveLead($member);

            }
        }

        return Command::SUCCESS;
    }

}
