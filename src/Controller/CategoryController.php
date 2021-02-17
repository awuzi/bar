<?php

namespace App\Controller;

use App\Repository\BeerRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category")
     * @param int $id
     * @param BeerRepository $beerRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function category(
        int $id,
        BeerRepository $beerRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $beersInCategory = $beerRepository->findByCategoryId($id);
        $category = $categoryRepository->find($id);

        return $this->render('category/category.html.twig', [
            'beersInCategory' => $beersInCategory,
            'category' => $category,
        ]);
    }
}
