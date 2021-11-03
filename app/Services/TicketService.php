<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use Illuminate\Support\Arr;

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
