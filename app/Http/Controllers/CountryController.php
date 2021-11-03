<?php


namespace App\Http\Controllers;


use App\Repositories\CountryRepository;

class CountryController extends Controller
{
    public function __construct(CountryRepository $repository)
    {
        $this->name = 'country';
        parent::__construct($repository);
    }

    public function index(CountryRepository $countryRepository){
        /** Init log */
        $this->action = 'List Country View';
        /** End Log */
        return view('countries.index',['countries'=>$countryRepository->index()]);
    }
}
