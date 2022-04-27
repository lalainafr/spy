<?php

namespace App\Controller;

use App\Entity\Speciality;
use App\Form\SpecialityType;
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
}
