<?php

namespace App\Components;

use App\Repository\TicketRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('tickets')]
class AllTicketsComponent
{
    public function __construct(
        private TicketRepository $ticketRepository
    ) {
    }

    public function getAllTickets(): array
    {
        return $this->ticketRepository->findAll();
    }
}
