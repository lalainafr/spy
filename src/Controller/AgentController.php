<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function edit(Request $request, EntityManagerInterface $em, $id, AgentRepository $agentRepository): Response
    {
        $agent = $agentRepository->findOneById($id);
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_agent');
        }

        return $this->render('agent/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/agent/delete/{id}", name="app_agent_delete")
     */
    public function delete(EntityManagerInterface $em, $id, AgentRepository $agentRepository): Response
    {
        $agent = $agentRepository->findOneById($id);
        $em->remove($agent);
        $em->flush();
        return $this->redirectToRoute('app_agent');
    }
}
