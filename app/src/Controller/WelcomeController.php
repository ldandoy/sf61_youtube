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

class WelcomeController extends AbstractController
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
        return $this->render('welcome/index.html.twig', [
            'form'      => $form->createView(),
            'tickets'   => $tickets
        ]);
    }
}
