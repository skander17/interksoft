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


}
