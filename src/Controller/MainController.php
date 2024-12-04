<?php
namespace App\Controller;

use App\Model\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController{
#[Route('/', name: 'app_main_home')]
public function home() : Response
{
    return $this->render('main/home.html.twig');

}


//    #[Route('/show/{id}', name: 'show')]
//    public function show(string $id = null, EventRepository $eventRepository ) : Response
//    {
//        $data = ['parties' => $eventRepository->findOne($id)];
//
//        return $this->render('main/show.html.twig', $data);
//
////        if($slug){
////            $y = str_replace('_', ' ', $slug);
////            $x = ucwords($y);
////            return new Response("Hi $x");
////        }else{
////            return new Response("Hi guest!");
////        }
//    }

}
