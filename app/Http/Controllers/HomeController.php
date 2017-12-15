<?php

namespace App\Http\Controllers;

use App\Http\Services\CervejaService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $cerveja_service;
    public function __construct(CervejaService $cerveja_service)
    {
        $this->middleware('auth');
        $this->cerveja_service = $cerveja_service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cervejas = $this->cerveja_service->getAll();
        return view('home', ['cervejas' => $cervejas]);
    }
}
