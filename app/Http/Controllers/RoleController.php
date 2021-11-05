<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repositories\Repository;

class RoleController extends Controller
{
    public function __construct(Role $role = null)
    {
        parent::__construct(new Repository($role));
    }

    public function index(Request $request){
        return response()->json($this->repository->index()->toArray());
    }
}
