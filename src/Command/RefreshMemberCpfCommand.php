<?php

namespace App\Command;

use App\Entity\MemberCpf;
use App\Repository\MemberCpfRepository;
use App\Services\ClientLearnyboxCpfService;
use App\Services\SaveMemberCpfService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshMemberCpfCommand extends Command
{

    private $saveMemberCpfService;
    private $memberCpfRepository;
    private $clientLearnyboxCpfService;

    protected static $defaultName = 'app:refresh-member-cpf';

    public function __construct(ClientLearnyboxCpfService $clientLearnyboxCpfService, SaveMemberCpfService $saveMemberCpfService, MemberCpfRepository $memberCpfRepository)
    {
        $this->clientLearnyboxCpfService = $clientLearnyboxCpfService;
        $this->memberCpfRepository = $memberCpfRepository;
        $this->saveMemberCpfService = $saveMemberCpfService;
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->clientLearnyboxCpfService->clientLearnyboxCpf();
        $total = $client->get('formations/53734/')->{'data'}->{'non_admin_users_count'};
       
        $count = $this->memberCpfRepository->countMemberCpf();

        $members = $client->get('formations/53734/membres?limit=' . $total . '&offset=' . $count[0]['1']);

        $increment = $total - $count[0]['1'];
        
        if($count[0]['1'] !== $total){
            for ($i = 0; $i < $increment; $i++) {
                $member = new MemberCpf();
                
                $member->setLastName($members->{'data'}[$i]->{'user'}->{'lname'});
                $member->setFirstName($members->{'data'}[$i]->{'user'}->{'fname'});
                $member->setEmail($members->{'data'}[$i]->{'user'}->{'email'});
                $member->setDateCreation(date_format(new \DateTime($members->{'data'}[$i]->{'dateinscription'}), 'Y-m-d'));
                $member->setLeadId('iv_' . $members->{'data'}[$i]->{'user'}->{'user_id'});
            

                $this->saveMemberCpfService->saveMemberCpf($member);

            }
        }

        return Command::SUCCESS;
    }

}
