<?php
namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//#[Route('/event')]
class EventController extends AbstractController{
    #[Route('/event', name: 'app_event_event')]
    public function index(EventRepository $eventRepository) : Response
    {

        $data = ['events' => $eventRepository->findAll()];


        return $this->render('event/home.html.twig', $data);

    }


    #[Route('/event/show/{id}', name: 'app_event_show')]
    public function show(int $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        if ($event) {
            return $this->render('event/show.html.twig', [
                'event' => $event,
            ]);
        } else {
            return new Response('No Party Found');
        }
    }


    #[Route('/event/{id}/edit', name: 'app_event_edit')]
    public function edit(Event $event, EntityManagerInterface $entityManager): Response
    {
        $entityManager->persist($event);
        $entityManager->flush();
        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
    }


    #[Route('/event/{id}/delete', name: 'app_event_delete')]
    public function delete(Event $event, EntityManagerInterface $entityManager): Response
    {


        if ($event) {
            $entityManager->remove($event);
            $entityManager->flush();
            $this->addFlash('success', 'Event has been deleted.');
        }

        return $this->redirectToRoute('app_event_event');
    }
    #[Route('/event/new', name: 'app_event_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $event->setName('Career Day')
            ->setDescription('Create Your Future')
            ->setBookedSeats(20);
//        dd($event);
        $entityManager->persist($event);
        $entityManager->flush();
//        return $this->render('event/new.html.twig', [])
        return new Response('The data was added successfully');
    }





}
