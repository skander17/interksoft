<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function index(){
        return $this->model::all();
    }


    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public function store(array $data){
        return $this->model::query()->create($data);
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function show($id){
        return $this->model::query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return bool|int
     * @throws \Exception
     */
    public function destroy($id){
        return $this->model::query()
            ->findOrFail($id)
            ->delete();
    }

    /**
     * @param $id
     * @param array $data
     * @return bool|int
     */
    public function update($id, array $data){
        return $this->model::query()
            ->findOrFail($id)
            ->update($data);
    }
}
