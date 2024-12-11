<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository
    ): Response
    {
        $categories = $categoryRepository->findAll();

        // Handle Create Form
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        // Handle submission of the Create form
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/category/{id}/delete', name: 'app_category_delete')]
    public function delete(
        Category $category,
        EntityManagerInterface $entityManager
    ): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('app_category');
    }

    #[Route('/category/{id}/edit', name: 'app_category_edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        Category $category
    ): Response {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }
//            $category, [
//            'action' => $this->generateUrl('app_category_test'),
//    #[Route('category/test', name: 'app_category_test')]
//    public function test(Request $request, CategoryRepository $categoryRepository){
//        return new Response('I am from new');
//    }
}
