<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Form\AgentChoiceType;
use App\Repository\AgentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgentController extends AbstractController
{
    /**
     * @Route("/agent", name="app_agent")
     */
    public function index(AgentRepository $agentRepository): Response
    {
        $agentList = $agentRepository->findAll();
        return $this->render('agent/index.html.twig', [
            'agentList' => $agentList,
        ]);
    }

    /**
     * @Route("/agent/add", name="app_agent_add")
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($agent);
            $em->flush();
            return $this->redirectToRoute('app_agent');
        }

        return $this->render('agent/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/agent/edit/{id}", name="app_agent_edit")
     */
    public function edit(Request $request, $id, EntityManagerInterface $em, AgentRepository $agentRepository): Response
    {
        $agent = $agentRepository->findOneById($id);
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_agent');
        }

        return $this->render('agent/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/agent/show/{id}", name="app_agent_show")
     */
    public function show(Request $request, EntityManagerInterface $em, $id, AgentRepository $agentRepository): Response
    {
        $agent = $agentRepository->findOneById($id);
        $specialities =  $agent->getSpeciality();

        return $this->render('agent/show.html.twig', [
            'agent' => $agent,
            'specialities' => $specialities
        ]);
    }
    /**
     * @Route("/agent/delete", name="app_agent_delete")
     */
    public function delete(EntityManagerInterface $em, AgentRepository $agentRepository, Request $request): Response
    {
        $searchForm = $this->createForm(AgentChoiceType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();
            $agentId = $data['agent']->getId();
            $agentDelete = $agentRepository->findOneById($agentId);
            $em->remove($agentDelete);
            $em->flush();
            return $this->redirectToRoute('app_agent');
        }
        return $this->render('agent/choice_delete.html.twig', [
            'searcForm' => $searchForm->createView()
        ]);
    }
}
