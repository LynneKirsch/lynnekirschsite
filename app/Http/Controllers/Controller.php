<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('home');
    }

    public function introduction()
    {
        return view('introduction');
    }

    public function resume()
    {
        return view('resume');
    }

    public function contact()
    {
        return view('contact');
    }

    public function design()
    {
        return view('design');
    }
}
