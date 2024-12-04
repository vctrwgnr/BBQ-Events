<?php
namespace App\Controller;

use App\Model\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController{
    #[Route('/event', name: 'app_event_event')]
    public function index(EventRepository $eventRepository) : Response
    {

        $data = ['parties' => $eventRepository->findAll()];


        return $this->render('event/home.html.twig', $data);

    }


    #[Route('/event/show/{id}', name: 'app_event_show')]
    public function show(int $id, EventRepository $eventRepository): Response
    {
        $party = $eventRepository->findOne($id);

        if($party){
            return $this->render('event/show.html.twig', [
                'party' => $party,
            ]);
        }else{
            return new Response('No Party Found');
        }


    }

    #[Route('/event/{id}/edit', name: 'app_event_edit')]
    public function edit(int $id, EventRepository $eventRepository): Response
    {
            return new Response('');
    }
    #[Route('/event/{id}/delete', name: 'app_event_delete')]
    public function delete(int $id, EventRepository $eventRepository): Response
    {
        return new Response('');
    }




}
