<?php

namespace App\Controller;

use App\Entity\Target;
use App\Form\TargetType;
use App\Form\TargetChoiceType;
use App\Repository\TargetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TargetController extends AbstractController
{
    /**
     * @Route("/target", name="app_target")
     */
    public function index(TargetRepository $targetRepository): Response
    {
        $targets = $targetRepository->findAll();

        return $this->render('target/index.html.twig', [
            'targets' => $targets,
        ]);
    }

    /**
     * @Route("/target/add", name="app_target_add")
     */
    public function add(TargetRepository $targetRepository, Request $request, EntityManagerInterface $em): Response
    {
        $target = new Target();
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($target);
            $em->flush();
            return $this->redirectToRoute('app_target');
        }

        return $this->render('target/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/target/edit/{id}", name="app_target_edit")
     */
    public function edit($id, TargetRepository $targetRepository, Request $request, EntityManagerInterface $em): Response
    {
        $target = $targetRepository->findOneById($id);
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($target);
            $em->flush();
            return $this->redirectToRoute('app_target');
        }

        return $this->render('target/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/target/delete", name="app_target_delete")
     */
    public function delete(TargetRepository $targetRepository, Request $request, EntityManagerInterface $em): Response
    {

        $searchForm = $this->createForm(TargetChoiceType::class);
        $searchForm->handleRequest($request);
        $data = $searchForm->getData();
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $targetId = $data['target']->getId();
            $targetDelete = $targetRepository->findOneById($targetId);
            $em->remove($targetDelete);
            $em->flush();
            return $this->redirectToRoute('app_target');
        }

        return $this->render('target/choice_delete.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }
}
