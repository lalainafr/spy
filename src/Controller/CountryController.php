<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Form\CountryChoiceType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryController extends AbstractController
{
    /**
     * @Route("/country", name="app_country")
     */
    public function index(CountryRepository $countryRepository): Response
    {
        $countries = $countryRepository->findAll();
        return $this->render('country/index.html.twig', [
            'countries' => $countries
        ]);
    }

    /**
     * @Route("/country/add", name="app_country_add")
     */
    public function add(EntityManagerInterface $em, CountryRepository $countryRepository, Request $request): Response
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($country);
            $em->flush();
            return $this->redirectToRoute('app_country');
        }
        return $this->render('country/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/country/edit/{id}", name="app_country_edit")
     */
    public function edit($id, EntityManagerInterface $em, CountryRepository $countryRepository, Request $request): Response
    {
        $country = $countryRepository->findOneById($id);
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($country);
            $em->flush();
            return $this->redirectToRoute('app_country');
        }
        return $this->render('country/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/country/delete", name="app_country_delete")
     */
    public function delete(CountryRepository $countryRepository,  EntityManagerInterface $em, Request $request): Response
    {

        $searchForm = $this->createForm(CountryChoiceType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $country = $searchForm->getData();
            $countryId = $country['country']->getId();
            $deleteCountry = $countryRepository->findOneById($countryId);
            $em->remove($deleteCountry);
            $em->flush();
            return $this->redirectToRoute('app_country');
        }
        return $this->render('country/choice_delete.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }
}
