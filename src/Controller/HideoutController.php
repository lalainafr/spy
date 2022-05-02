<?php

namespace App\Controller;

use App\Entity\Hideout;
use App\Form\HideoutType;
use App\Form\HideoutChoiceType;
use App\Repository\HideoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HideoutController extends AbstractController
{
    /**
     * @Route("/hideout", name="app_hideout")
     */
    public function index(HideoutRepository $hideoutRepository): Response
    {
        $hideout = $hideoutRepository->findAll();
        return $this->render('hideout/index.html.twig', [
            'hideouts' => $hideout
        ]);
    }

    /**
     * @Route("/hideout/add", name="app_hideout_add")
     */
    public function add(HideoutRepository $hideoutRepository, Request $request, EntityManagerInterface $em): Response
    {
        $hideout = new Hideout();
        $form = $this->createForm(HideoutType::class, $hideout);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($hideout);
            $em->flush();
            return $this->redirectToRoute('app_hideout');
        }

        return $this->render('hideout/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/hideout/edit/{id}", name="app_hideout_edit")
     */
    public function edit($id, HideoutRepository $hideoutRepository, Request $request, EntityManagerInterface $em): Response
    {
        $hideout = $hideoutRepository->findOneById($id);
        $form = $this->createForm(HideoutType::class, $hideout);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($hideout);
            $em->flush();
            return $this->redirectToRoute('app_hideout');
        }

        return $this->render('hideout/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/hideout/delete", name="app_hideout_delete")
     */
    public function delete(HideoutRepository $hideoutRepository,  EntityManagerInterface $em, Request $request): Response
    {

        $searchForm = $this->createForm(HideoutChoiceType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $hideout = $searchForm->getData();
            $hideoutId = $hideout['hideout']->getId();
            $deleteHideout = $hideoutRepository->findOneById($hideoutId);
            $em->remove($deleteHideout);
            $em->flush();
            return $this->redirectToRoute('app_hideout');
        }
        return $this->render('hideout/choice_delete.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }
}
