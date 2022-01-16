<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\ModelMail;
use App\Form\ChangeContactType;
use App\Form\ChangePasswordType;
use App\Form\ChangePersonnalDataType;
use App\Form\ModelMailType;
use App\Repository\ModelMailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {

        return $this->render('users/index.html.twig');
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
