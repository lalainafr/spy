<?php

namespace App\Controller;

use App\Entity\Code;
use App\Form\CodeType;
use App\Repository\CodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CodeController extends AbstractController
{
    /**
     * @Route("/code", name="app_code")
     */
    public function index(CodeRepository $codeRepository): Response
    {
        $codes = $codeRepository->findAll();
        return $this->render('code/index.html.twig', [
            'codes' => $codes
        ]);
    }

    /**
     * @Route("/code/add", name="app_code_add")
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $code = new Code();
        $form = $this->createForm(CodeType::class, $code);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($code);
            $em->flush();
            return $this->redirectToRoute('app_code');
        }

        return $this->render('code/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/code/edit/{id}", name="app_code_edit")
     */
    public function edit($id, CodeRepository $codeRepository, Request $request, EntityManagerInterface $em): Response
    {
        $code = $codeRepository->findOneById($id);
        $form = $this->createForm(CodeType::class, $code);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($code);
            $em->flush();
            return $this->redirectToRoute('app_code');
        }

        return $this->render('code/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/code/delete/{id}", name="app_code_delete")
     */
    public function delete($id, CodeRepository $codeRepository, EntityManagerInterface $em): Response
    {
        $code = $codeRepository->findOneById($id);
        $em->remove($code);
        $em->flush();

        return $this->redirectToRoute('app_code');
    }
}
