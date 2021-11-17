<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TicketRepository;

/** @property TicketRepository $repository */
class TicketService extends Service
{


    public function __construct(TicketRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return array
     */
    public function getCurrentUserTickets(): array
    {
        /** @var User $current_user */
        $current_user = auth()->user();
        return  $this->getClientTickets($current_user->client_id);
    }

    /**
     * @param $client_id
     * @return array
     */
    public function getClientTickets($client_id): array
    {
        return  $this->repository->getClientTickets($client_id);
    }

    /**
     * @return array
     */
    public function getCountedLatestTickets(): array
    {
        $countedObjet = $this->repository->countTicketsDaily();
        $totalArray   = [];
        foreach ($countedObjet as $item){
            $totalArray[] = $item->total;
        }

        return $totalArray;
    }

    /**
     * @return Array|null
     */
    public function getMostVisitedAirport(): ?array
    {
        $mostVisited = $this->repository->getMostVisitedAirports();

        if (count($mostVisited)){
            return $mostVisited[0];
        }

        return null;
    }

    /**
     * @return array|null
     */
    public function getMostFrequentClient(): ?array
    {
        $mostFrequent = $this->repository->getMostFrequentClients();

        if (count($mostFrequent)){
            return $mostFrequent[0];
        }

        return null;
    }
}
