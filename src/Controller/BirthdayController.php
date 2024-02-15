<?php
// src/Controller/BirthdayController.php

namespace App\Controller;

use App\Entity\Birthday;
use App\Form\BirthdayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BirthdayController extends AbstractController
{
    /**
     * @Route("/birthday/add", name="add_birthday", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $birthday = new Birthday();
        $form = $this->createForm(BirthdayType::class, $birthday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($birthday);
            $entityManager->flush();

            return $this->redirectToRoute('list_birthday');
        }

        return $this->render('birthday/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/birthday/{id}/edit", name="edit_birthday", methods={"GET","POST"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $birthday = $entityManager->getRepository(Birthday::class)->find($id);

        if (!$birthday) {
            throw $this->createNotFoundException('L\'anniversaire avec l\'ID ' . $id . ' n\'existe pas.');
        }

        $form = $this->createForm(BirthdayType::class, $birthday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('list_birthday');
        }

        return $this->render('birthday/edit.html.twig', [
            'birthday' => $birthday,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/birthday/{id}", name="delete_birthday", methods={"POST"})
     */
    public function delete(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $birthday = $entityManager->getRepository(Birthday::class)->find($id);

        if (!$birthday) {
            throw $this->createNotFoundException('L\'anniversaire avec l\'ID ' . $id . ' n\'existe pas.');
        }

        if ($this->isCsrfTokenValid('delete' . $birthday->getId(), $request->request->get('_token'))) {
            $entityManager->remove($birthday);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_birthday');
    }

    /**
     * @Route("/birthday/list", name="list_birthday", methods={"GET"})
     */
    public function list(): Response
    {
        $birthdays = $this->getDoctrine()->getRepository(Birthday::class)->findAll();

        return $this->render('birthday/list.html.twig', [
            'birthdays' => $birthdays,
        ]);
    }
}
