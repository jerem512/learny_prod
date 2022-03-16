<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\ModelMail;
use App\Entity\Objectives;
use App\Form\ChangeContactType;
use App\Form\ChangePasswordType;
use App\Form\ChangePersonnalDataType;
use App\Form\ModelMailType;
use App\Repository\ModelMailRepository;
use App\Repository\CloseRepository;
use App\Repository\ObjectivesRepository;
use App\Services\CheckOfferService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/app", name="app_")
 */

class UsersController extends AbstractController
{
    /**
     * @Route("/me", name="me")
     */
    public function index(CloseRepository $closeRepository, CheckOfferService $checkOfferService, Request $request, ObjectivesRepository $objectivesRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $salary = [];
        $goals = $objectivesRepository->findOneBy(['user_id' => $user]);
        
        $goals_week = $goals->getGoalWeek();
        $goals_month = $goals->getGoalMonth();
        $goals_year = $goals->getGoalYear();
        $sales = $closeRepository->findBy(['user_id' => $user->getId()]);
        $action = $request->request->get('action');

        foreach($sales as $sale){
            $offer = $checkOfferService->checkOffer($sale->getName());
            $salary[] = $offer->getCommission();
        }
        
        $target_week = (array_sum($salary) / $goals_week * 100) < 100 ? (array_sum($salary) / $goals_week * 100) : 100;
        $target_month = (array_sum($salary) / $goals_month * 100) < 100 ? (array_sum($salary) / $goals_month * 100) : 100;
        $target_year = (array_sum($salary) / $goals_year * 100) < 100 ? (array_sum($salary) / $goals_year * 100) : 100;

        if(isset($action) && !empty($action) && $action == 'data'){
            if(isset($goals) && !empty($goals)){
                $goals->setGoalWeek($request->request->get('rangeWeek'));
                $goals->setGoalMonth($request->request->get('rangeMonth'));
                $goals->setGoalYear($request->request->get('rangeYear'));
                $entityManager->persist($goals);
                $entityManager->flush();

                return new JsonResponse('done', 200);
            }else{
                $no_goals = new Objectives();
                $no_goals->setGoalWeek(500);
                $no_goals->setGoalMonth(2000);
                $no_goals->setGoalYear(24000);
            }
        }


        return $this->render('users/index.html.twig', [
            'goals_week' => $goals_week,
            'goals_month' => $goals_month,
            'goals_year' => $goals_year,
            'target_week' => \round($target_week, 2),
            'target_month' => \round($target_month, 0),
            'target_year' => round($target_year, 0)
        ]);
    }

    /**
     * @Route("/me/edit", name="me_edit")
     */
    public function edit(Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasherInterface,
        ModelMailRepository $modelMailRepository
    ): Response {

        $url = $this->generateUrl('app_me_edit', [
            '_fragment' => 'chang-pwd',
        ]);
        $users = $this->getUser();
        $form_password = $this->createForm(ChangePasswordType::class, $users);
        $form_password->handleRequest($request);

        if ($form_password->isSubmitted() && $form_password->isValid()) {
            $old_pwd = $request->request->get('change_password')['oldPassword'];
            $new_pwd = $request->request->get('change_password')['Password']['first'];
            $new_pwd_confirm = $request->request->get('change_password')['Password']['second'];

            if ($userPasswordHasherInterface->isPasswordValid($users, $old_pwd) === true) {
                if ($new_pwd == $new_pwd_confirm) {
                    $users->setPassword(
                        $userPasswordHasherInterface->hashPassword(
                            $users,
                            $form_password->get('Password')->getData()
                        )
                    );

                    $entityManager->persist($users);
                    $entityManager->flush();
                    $this->addFlash('success', 'Mot de passe changé avec succès');

                    return $this->redirect($url);
                }
            } else {
                $this->addFlash('error', 'Ancien mot de passe invalide');
            }
        }

        $form_personnal_info = $this->createForm(ChangePersonnalDataType::class, $users);
        $form_personnal_info->handleRequest($request);

        if ($form_personnal_info->isSubmitted() && $form_personnal_info->isValid()) {
            if ($request->files->get('change_personnal_data')['image'] !== null) {
                $image = $form_personnal_info->get('image')->getData();
                if ($image->guessExtension() == 'jpg' || $image->guessExtension() == "jpeg") {
                    $file = $users->getFirstName() . '.' . $image->guessExtension();
                    //dd($file);
                    $img = new Images();
                    $img->setName($file);
                    
                    if (file_exists($this->getParameter('image_directory') . '/' . $file)) {
                        unlink($this->getParameter('image_directory') . '/' . $file);
                        $entityManager->remove($users->getImages());
                        $entityManager->flush();
                    }

                    $image->move(
                        $this->getParameter('image_directory'),
                        $file
                    );

                    $users->setImages($img);
                } else {
                    $this->addFlash('success', 'Mot de passe changé avec succès');
                }
            }
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'Mot de passe changé avec succès');
        }

        $form_change_contact = $this->createForm(ChangeContactType::class, $users);
        $form_change_contact->handleRequest($request);

        if ($form_change_contact->isSubmitted() && $form_change_contact->isValid()) {
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'Mot de passe changé avec succès');
        }

        $modelMail = new ModelMail();
        $user = $this->getUser();
        $form_new_model = $this->createForm(ModelMailType::class, $modelMail);
        $form_new_model->handleRequest($request);

        if ($form_new_model->isSubmitted() && $form_new_model->isValid()) {
            $user->addModelMail($modelMail);
            $entityManager->persist($modelMail);
            $entityManager->flush();

            return $this->redirectToRoute('app_me_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users/edit.html.twig', [
            'show_model' => $modelMailRepository->findAll(),
            'form_new_model' => $form_new_model->createView(),
            'editPasswordForm' => $form_password->createView(),
            'personnalInfoForm' => $form_personnal_info->createView(),
            'changeContactForm' => $form_change_contact->createView(),

        ]);
    }
}
