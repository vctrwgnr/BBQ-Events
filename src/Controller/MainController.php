<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController{
#[Route('/', name: 'home')]
public function home() : Response
{
    return new Response("Hi beautiful");

}

    #[Route('/show/{slug}', name: 'show')]
    public function show(string $slug = null) : Response
    {

        if($slug){
            $y = str_replace('_', ' ', $slug);
            $x = ucwords($y);
            return new Response("Hi $x");
        }else{
            return new Response("Hi guest!");
        }
    }

}
