<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Form\TypeChoiceType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeController extends AbstractController
{
    /**
     * @Route("/type", name="app_type")
     */
    public function index(TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findAll();
        return $this->render('type/index.html.twig', [
            'types' => $types
        ]);
    }
    /**
     * @Route("/type/add", name="app_type_add")
     */
    public function add(TypeRepository $typeRepository, Request $request, EntityManagerInterface $em): Response
    {
        $type =  new Type();
        $form =  $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute('app_type');
        }

        return $this->render('type/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/type/edit/{id}", name="app_type_edit")
     */
    public function edit($id, TypeRepository $typeRepository, Request $request, EntityManagerInterface $em): Response
    {
        $type =  $typeRepository->findOneById($id);
        $form =  $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute('app_type');
        }

        return $this->render('type/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/type/delete/", name="app_type_delete")
     */
    public function delete(TypeRepository $typeRepository, Request $request, EntityManagerInterface $em): Response
    {
        $searchForm = $this->createForm(TypeChoiceType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();
            $typeId = $data['target']->getId();
            $typeDelete = $typeRepository->findOneById($typeId);
            $em->remove($typeDelete);
            $em->flush();
            return $this->redirectToRoute('app_type');
        }

        return $this->render('type/choice_delete.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }
}
