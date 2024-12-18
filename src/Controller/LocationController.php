<?php
namespace App\Controller;

use App\Form\LocationType;
use App\Entity\Location;
use App\Repository\EventRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//#[Route('/event')]
class LocationController extends AbstractController{
    #[Route('/location', name: 'app_location_location')]
    public function index(LocationRepository $locationRepository) : Response
    {
        return $this->render('location/home.html.twig',  ['locations' => $locationRepository->findAll()]);

    }

//    #[Route('/location/new', name: 'app_location_new')]
//    public function new(EntityManagerInterface $entityManager, Request $request): Response
//    {
//        $location = new Location();
//        $form = $this->createForm(LocationType::class, $location);
//        $form->handleRequest($request);
//
////        $location->setName('Hamburg')
////            ->setDescription('Conference Hall')
////            ->setAddress('Haupstr 10')
////            ->setCapacity(20);
//        $entityManager->persist($location);
//        $entityManager->flush();
//
////        return new Response('The data was added successfully');
//        return $this->redirectToRoute('app_location_location');
//    }

    #[Route('/location/new', name: 'app_location_new')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('app_location_location');
        }

        return $this->render('location/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/location/show/{id}', name: 'app_location_show')]
    public function show(int $id, LocationRepository $locationRepository): Response
    {
        $location = $locationRepository->find($id);

        if($location){
            return $this->render('location/show.html.twig', [
                'location' => $location,

            ]);
        }else{
            return new Response('No Location Found');
        }


    }

    #[Route('/location/{id}/edit', name: 'app_location_edit')]
    public function edit(Location $location, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('app_location_show', ['id' => $location->getId()]);

        }

        return $this->render('location/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/location/{id}/delete', name: 'app_location_delete', methods: ['POST', 'GET'])]
    public function delete(int $id, LocationRepository $locationRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        //In case you want to allow deletion on cascade
//        foreach($location->getEvents() as $event){
//            $event->setLocation(null);
//        }

        // Fetch the location entity
        $location = $locationRepository->find($id);

        if (!$location) {
            $this->addFlash('error', 'Location not found.');
            return $this->redirectToRoute('app_location_location');
        }

        // Check if location has associated events
        if ($location->getEvents()->count() > 0) {
            $this->addFlash('error', 'Cannot delete this location because it is associated with events. Please remove the events first.');

            // Return the same page without redirection
            return $this->render('location/show.html.twig', [
                'location' => $location,
            ]);
        }

        // Perform the deletion
        try {
            $entityManager->remove($location);
            $entityManager->flush();
            $this->addFlash('success', 'Location deleted successfully.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'An error occurred while trying to delete the location.');
        }

        // Redirect to location list after deletion
        return $this->redirectToRoute('app_location_location');
    }

}
