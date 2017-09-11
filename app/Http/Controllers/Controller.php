<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function getBase()
    {
        $base = "";

        if($_SERVER["HTTP_HOST"] == "localhost") {
            $base = "/lynnekirschsite/public";
        }

        return $base;
    }

    private function view (string $template): View
    {
        return view($template, ["base" => $this->getBase()]);
    }

    public function index()
    {
        return $this->view("home");
    }

    public function introduction()
    {
        return $this->view("introduction");
    }

    public function resume()
    {
        return $this->view("resume");
    }

    public function contact()
    {
        return $this->view("contact");
    }

    public function design()
    {
        return $this->view("design");
    }
}
