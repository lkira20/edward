<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codigos;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productos = Product::orderBy('id', 'desc')->get();

        $codigos = Codigos::orderBy('id', 'desc')->paginate(3);
        //selector
        $codigos2 = Codigos::orderBy('id', 'desc')->get();

        return view('home', ['codigos' => $codigos, 'productos' => $productos, 'codigos2' => $codigos2]);
    }


}
