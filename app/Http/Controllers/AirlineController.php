<?php

namespace App\Http\Controllers;

use App\Repositories\AirlineRepository;

class AirlineController extends Controller
{

    protected array $storeRules = [
        'ful_name' => ['required']
    ];
    protected array $messages = [
        'ful_name.required'
    ];
    public function __construct(AirlineRepository $repository)
    {
        $this->name = 'airline';
        parent::__construct($repository);
    }

    public function index(AirlineRepository $repository)
    {
        return view('airlines.index', ['airlines' => $repository->index()]);
    }

}
