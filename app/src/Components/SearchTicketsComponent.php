<?php

namespace App\Components;

use App\Repository\TicketRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('search_tickets')]
class SearchTicketsComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private TicketRepository $ticketRepository
    ) {
    }

    #[LiveAction]
    public function getAllTickets(): array
    {
        return $this->ticketRepository->findByQuery($this->query);
    }
}
