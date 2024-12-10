<?php
namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event_event')]
    public function index(EventRepository $eventRepository): Response
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

        return $this->render('event/home.html.twig', [
            'events' => $events,
        ]);


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
    public function edit(Event $event, EntityManagerInterface $entityManager, Request $request): Response
    {
//        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('app_event_show', ['id' => $event->getId()]));
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/event/{id}/delete', name: 'app_event_delete')]
    public function delete(Event $event, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($event) {
            $entityManager->remove($event);
            $entityManager->flush();
            $this->addFlash('success', 'Event has been deleted.');
        }
//        $this->addFlash('success', 'The Event was successfully updated');

        return $this->redirectToRoute('app_event_event');
    }



    #[Route('/event/new', name: 'app_event_new')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();
        return $this->redirect($this->generateUrl('app_event_event'));
        }

        return $this->render('event/new.html.twig', [
            'form' => $form->createView()
        ]);
    }



//    #[Route('/event/test', name: 'app_event_test')]
//    public function test(Request $request): Response
//    {
//        if ($request->isMethod('GET')) {
//            return $this->render('event/test.html.twig');
//        } elseif ($request->isMethod('POST')) {
//            return new Response ('hi from post');
//        }
//
//    }


}
