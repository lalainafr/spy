<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MissionController extends AbstractController
{
    /**
     * @Route("/mission", name="app_mission")
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

        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
            'agents' => $agents
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
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/mission/delete/{id}", name="app_mission_delete")
     */
    public function delete($id, MissionRepository $missionRepository,  EntityManagerInterface $em): Response
    {
        $mission = $missionRepository->findOneById($id);
        $em->remove($mission);
        $em->flush();
        return $this->redirectToRoute('app_mission');
    }
}
