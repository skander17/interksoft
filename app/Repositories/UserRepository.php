<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRepository extends Repository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return Builder|User
     */
    public function store(array $data){
        /** @var User $user */
        $user =  $this->model::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($data['roles'] ?? [3]);

        return $user;
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
        if (isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        $user =  $this->model::query()
            ->findOrFail($id)
            ->update($data);

        if (isset($data['roles'])){
            User::find($id)->syncRoles($data['roles']);
        }
        return $user;
    }

}
