<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\StatusType;
use App\Form\StatusChoiceType;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatusController extends AbstractController
{
    /**
     * @Route("/status", name="app_status")
     */
    public function index(StatusRepository $statusRepository): Response
    {
        $status = $statusRepository->findAll();
        return $this->render('status/index.html.twig', [
            'status' => $status,
        ]);
    }
    /**
     * @Route("/status/add", name="app_status_add")
     */
    public function add(StatusRepository $statusRepository, Request $request, EntityManagerInterface $em): Response
    {
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($status);
            $em->flush();
            return $this->redirectToRoute('app_status');
        }
        return $this->render('status/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/status/edit/{id}", name="app_status_edit")
     */
    public function edit($id, StatusRepository $statusRepository, Request $request, EntityManagerInterface $em): Response
    {
        $status = $statusRepository->findOneById($id);
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($status);
            $em->flush();
            return $this->redirectToRoute('app_status');
        }
        return $this->render('status/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/type/delete/", name="app_status_delete")
     */
    public function delete(StatusRepository $statusRepository, Request $request, EntityManagerInterface $em): Response
    {
        $searchForm = $this->createForm(StatusChoiceType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();
            $statusId = $data['status']->getId();
            $statusDelete = $statusRepository->findOneById($statusId);
            $em->remove($statusDelete);
            $em->flush();
            return $this->redirectToRoute('app_status');
        }

        return $this->render('status/choice_delete.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }
}
