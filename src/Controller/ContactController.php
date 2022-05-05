<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\ContactChoiceType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();
        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/contact/add", name="app_contact_add")
     */
    public function add(ContactRepository $contactRepository, Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contact);
            $em->flush();
            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/contact/edit/{id}", name="app_contact_edit")
     */
    public function edit($id, ContactRepository $contactRepository, Request $request, EntityManagerInterface $em): Response
    {
        $contact = $contactRepository->findOneById($id);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contact);
            $em->flush();
            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/contact/delete", name="app_contact_delete")
     */
    public function delete(ContactRepository $contactRepository,  EntityManagerInterface $em, Request $request): Response
    {

        $searchForm = $this->createForm(ContactChoiceType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $hideout = $searchForm->getData();
            $hideoutId = $hideout['contact']->getId();
            $deleteHideout = $contactRepository->findOneById($hideoutId);
            $em->remove($deleteHideout);
            $em->flush();
            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/choice_delete.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }
}
