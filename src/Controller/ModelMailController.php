<?php

namespace App\Controller;

use App\Entity\ModelMail;
use App\Form\ModelMailType;
use App\Repository\ModelMailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/edit", name="app_")
 */
class ModelMailController extends AbstractController
{
    /**
     * @Route("/new/", name="model_mail_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ModelMailRepository $modelMailRepository): Response
    {
        $modelMail = new ModelMail();
        $user = $this->getUser();
        $form = $this->createForm(ModelMailType::class, $modelMail);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->addModelMail($modelMail);
            $entityManager->persist($modelMail);
            $entityManager->flush();

            return $this->redirectToRoute('app_me_edit', [], Response::HTTP_SEE_OTHER);
        }
        $accompagnement = $modelMailRepository->findBy(['Type' => 'accompagnement']);

        return $this->renderForm('model_mail/new.html.twig', [
            'model_mail' => $modelMail,
            'form_new_model' => $form,
            'accompagnement' => $accompagnement
        ]);
    }

    /**
     * @Route("/{id}/show", name="model_mail_show", methods={"GET"})
     */
    public function show(ModelMail $modelMail): Response
    {
        return $this->render('model_mail/show.html.twig', [
            'model_mail' => $modelMail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="model_mail_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ModelMail $modelMail, EntityManagerInterface $entityManager): Response
    {
        $form_new_model = $this->createForm(ModelMailType::class, $modelMail);
        $form_new_model->handleRequest($request);

        if ($form_new_model->isSubmitted() && $form_new_model->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_me_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('model_mail/edit.html.twig', [
            'model_mail' => $modelMail,
            'form_new_model' => $form_new_model,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="model_mail_delete", methods={"POST"})
     */
    public function delete(Request $request, ModelMail $modelMail, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$modelMail->getId(), $request->request->get('_token'))) {
            $entityManager->remove($modelMail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_me_edit', [], Response::HTTP_SEE_OTHER);
    }
}
