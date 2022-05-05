<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Form\MissionChoiceType;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MissionController extends AbstractController
{

    /**
     * @Route("/", name="app_mission")
     */
    public function index(MissionRepository $missionRepository): Response
    {
        $mission = $missionRepository->findAll();

        return $this->render('mission/index.html.twig', [
            'missionList' => $mission
        ]);
    }

    /**
     * @Route("/mission/add", name="app_mission_add")
     */
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($mission);
            $em->flush();
            return $this->redirectToRoute('app_mission');
        }
        return $this->render('mission/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/mission/show/{id}", name="app_mission_show")
     */
    public function show($id, MissionRepository $missionRepository): Response
    {
        $mission = $missionRepository->findOneById($id);
        $agents = $mission->getAgent();
        $speciality = $mission->getSpeciality();
        $targets = $mission->getTarget();
        $type = $mission->getType();
        $status = $mission->getStatus();
        $hideouts = $mission->getHideout();
        $country = $mission->getCountry();


        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
            'agents' => $agents,
            'speciality' => $speciality,
            'targets' => $targets,
            'type' => $type,
            'status' => $status,
            'hideouts' =>  $hideouts,
            'country' => $country
        ]);
    }
    /**
     * @Route("/mission/edit/{id}", name="app_mission_edit")
     */
    public function edit($id, MissionRepository $missionRepository, Request $request, EntityManagerInterface $em): Response
    {

        $mission = $missionRepository->findOneById($id);
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_mission');
        }

        return $this->render('mission/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/mission/delete", name="app_mission_delete")
     */
    public function delete(MissionRepository $missionRepository,  EntityManagerInterface $em, Request $request): Response
    {

        $searchForm = $this->createForm(MissionChoiceType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $mission = $searchForm->getData();
            $missionId = $mission['mission']->getId();
            $deleteMission = $missionRepository->findOneById($missionId);
            $em->remove($deleteMission);
            $em->flush();
            return $this->redirectToRoute('app_mission');
        }
        return $this->render('mission/choice_delete.html.twig', [
            'searcForm' => $searchForm->createView()
        ]);
    }
}
