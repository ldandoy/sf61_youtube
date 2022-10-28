<?php

namespace App\Components;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('ticket')]
class TicketComponent
{
    public int $id;

    public function __construct(
        private TicketRepository $ticketRepository
    ) {
    }

    public function getTicket(): Ticket
    {
        return $this->ticketRepository->find($this->id);
    }
}
