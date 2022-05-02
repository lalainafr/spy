<?php

namespace App\Controller;

use App\Entity\Speciality;
use App\Form\SpecialityType;
use App\Form\SpecialityChoiceType;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpecialityController extends AbstractController
{
    /**
     * @Route("/speciality", name="app_speciality")
     */
    public function index(SpecialityRepository $specialityRepository): Response
    {
        $Specialities = $specialityRepository->findAll();
        return $this->render('speciality/index.html.twig', [
            'specialitiesList' => $Specialities,
        ]);
    }

    /**
     * @Route("/speciality/add", name="app_speciality_add")
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $speciality = new Speciality();
        $form = $this->createForm(SpecialityType::class, $speciality);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($speciality);
            $em->flush();
            return $this->redirectToRoute('app_speciality');
        }

        return $this->render('speciality/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/speciality/edit/{id}", name="app_speciality_edit")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, SpecialityRepository $specialityRepository): Response
    {
        $speciality = $specialityRepository->findOneById($id);
        $form = $this->createForm(SpecialityType::class, $speciality);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($speciality);
            $em->flush();
            return $this->redirectToRoute('app_speciality');
        }

        return $this->render('speciality/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/speciality/delete", name="app_speciality_delete")
     */
    public function delete(Request $request, EntityManagerInterface $em, SpecialityRepository $specialityRepository): Response
    {

        $searchForm = $this->createForm(SpecialityChoiceType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $speciality = $searchForm->getData();
            dd($speciality);
            $specialityId = $speciality['speciality']->getId();
            $deleteMission = $specialityRepository->findOneById($specialityId);
            $em->remove($deleteMission);
            $em->flush();
            return $this->redirectToRoute('app_speciality');
        }

        return $this->render('speciality/choice_delete.html.twig', [
            'searcForm' => $searchForm->createView()
        ]);
    }
}
