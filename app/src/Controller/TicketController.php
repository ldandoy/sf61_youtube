<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ManagerRegistry;


use App\Entity\Ticket;
use App\Form\TicketType;

class TicketController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        // Get all the tickets form the bdd
        $tickets = $doctrine->getRepository(Ticket::class)->findAll();
        
        // Generate the form to create a ticket
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        
        // Manage if we get en POST request to create a new ticket
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $ticket = $form->getData();
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_welcome');
        }

        // Render the view.
        return $this->render('ticket/index.html.twig', [
            'form'      => $form->createView(),
            'tickets'   => $tickets
        ]);
    }

    #[Route('/ticket/{id}/delete', name: 'ticket_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(Ticket $ticket, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($ticket);
        $entityManager->flush();

        return $this->redirectToRoute('app_welcome');
    }

    #[Route('/ticket/{id}/edit', name: 'ticket_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(Ticket $ticket, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        
        // Manage if we get en POST request to create a new ticket
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            
            $ticket = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('app_welcome');
        }

        // Render the view.
        return $this->render('ticket/edit.html.twig', [
            'form'      => $form->createView(),
            'ticket'    => $ticket
        ]);
    }

    #[Route('/ticket/{id}', name: 'ticket_show')]
    #[IsGranted('ROLE_USER')]
    public function show(Ticket $ticket): Response
    {
        // Render the view.
        return $this->render('ticket/show.html.twig', [
            'ticket'    => $ticket
        ]);
    }
}
