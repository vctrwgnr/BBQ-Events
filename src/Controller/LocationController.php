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

    #[Route('/location/new', name: 'app_location_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $location = new Location();
        $location->setName('Hamburg')
            ->setDescription('Conference Hall')
            ->setAddress('Haupstr 10')
            ->setCapacity(20);
        $entityManager->persist($location);
        $entityManager->flush();

        return new Response('The data was added successfully');
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
    public function edit(Location $location, EntityManagerInterface $entityManager): Response
    {
        $entityManager->persist($location);
        $entityManager->flush();
        return $this->redirectToRoute('app_location_show', ['id' => $location->getId()]);
    }


    #[Route('/location/{id}/delete', name: 'app_location_delete')]
    public function delete(int $id, LocationRepository $locationRepository, EntityManagerInterface $entityManager): Response
    {
        $location = $locationRepository->find($id);

        if ($location) {
            $entityManager->remove($location);
            $entityManager->flush();
            $this->addFlash('success', 'Location has been deleted.');
        }

        return $this->redirectToRoute('app_location_location');
    }

}