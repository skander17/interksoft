<?php


namespace App\Repositories;



use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketRepository extends Repository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        return $this->model::with([
            'client','airport_origin','airport_arrival','user','airline','operation'
        ])->get();
    }

    public function show($id)
    {
        return Ticket::query()
            ->with(['client','airport_origin','airport_arrival','user','airline','operation'])
            ->findOrFail($id);
    }


    public function store(array $data)
    {
        try{
            DB::beginTransaction();
                $ticket = parent::store($data);

                $operation = $ticket->operation()->create([
                    "ticket_id"=>$ticket->id,
                    "state_id"=>$data['state_id'] ?? 1,
                    "user_id"=>$data['user_id'],

                ]);

                $operation->operationDetail()->create(
                    [
                        "operation_id"=>$operation->id,
                        "user_id"=>$data['user_id'],
                        "state_id"=>$data['state_id'] ?? 1
                    ]
                );
            DB::commit();
            return $this->show($operation->id);
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @return array
     */
    public function countTicketsDaily(): array
    {

        $weekStartDate = date('Y-m-d H:i', strtotime('-6 days')) ;
        $weekEndDate   = date('Y-m-d H:i');

        $generatedSeriesQuery = sprintf(
            "SELECT t.day::date FROM generate_series(timestamp '%s', timestamp '%s', interval '1 day') AS t(day)",
            $weekStartDate,
            $weekEndDate
        );

        return DB::select("SELECT
            to_char(s.day,'yyyy-mm-dd') AS day , 
            count(t.id) AS total 
            
            FROM ( 
                $generatedSeriesQuery
            ) s 
            LEFT JOIN tickets t ON t.created_at::date = s.day AND deleted_at IS NULL 
            GROUP BY s.day 
            ORDER BY s.day ; 
            ");

    }


    /**
     * @return array
     */
    public function getMostVisitedAirports(): array
    {
        return $this->model::query()
            ->select('airport_arrival_id', DB::raw('COUNT(airport_arrival_id)'))
            ->groupBy('airport_arrival_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray()
            ;
    }

    public function getMostFrequentClients(): array
    {
        return $this->model::query()
            ->select('client_id',DB::raw('COUNT(client_id)'))
            ->groupBy('client_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();
    }

    /**
     * @return int
     */
    public function getTotalOfTickets(): int
    {
        return $this->model::query()->count('id');
    }

    /**
     * @param int $client_id
     * @return array
     */
    public function getClientTickets(int $client_id): array
    {
        return $this->model::query()
            ->where('client_id','=',$client_id)
            ->get()
            ->toArray();
    }
}
