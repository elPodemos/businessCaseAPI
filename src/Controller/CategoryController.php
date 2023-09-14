<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/category')]
class CategoryController extends AbstractController
{

    #[Route('/', name: 'app_category_index')]
    public function indexAPI(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->json($categories, 200, [], ['groups' => 'allCategory']);
    }

    // #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $category = new Category();
    //     $form = $this->createForm(CategoryType::class, $category);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($category);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('category/new.html.twig', [
    //         'category' => $category,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_category_shwo')]
    public function shwoAPI($id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        return $this->json($category, 200, [], ['groups' => 'allCategory']);
    }

    // #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(CategoryType::class, $category);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('category/edit.html.twig', [
    //         'category' => $category,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    // public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($category);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    // }
}
