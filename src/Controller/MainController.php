<?php
namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class MainController extends AbstractController{
#[Route('/', name: 'app_main_home')]
public function home(EventRepository $eventRepository) : Response
{
    $events = $eventRepository->findAll();
    $defaultImagePath = 'img/default.jpg';

    foreach ($events as $event) {
        $imagePath = $this->getParameter('kernel.project_dir') . '/public/img/' . $event->getId() . '.jpg';
        if (!file_exists($imagePath)) {
            $event->imagePath = $defaultImagePath;
        } else {
            $event->imagePath = 'img/' . $event->getId() . '.jpg';
        }
    }
    return $this->render('main/home.html.twig', ['events' => $events],);

}



    #[Route('/event/{id}/like', name: 'app_event_like', methods: ['POST'])]
    public function like(Event $event, EntityManagerInterface $entityManager, Request $request): Response
    {
        $event->incrementLikes();
        $entityManager->flush();

        return $this->redirectToRoute('app_main_home');
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
