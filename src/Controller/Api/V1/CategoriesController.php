<?php

namespace App\Controller\Api\V1;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// creating a global route for categories BREAD
/**
 * @Route("/api/v1/categorie", name="api_v1_categories_")
 */
class CategoriesController extends AbstractController
{
    // function browse is able to find a list of all categories and return this with json
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(CategoryRepository $categoryRepository): Response
    {
        $allCategories = $categoryRepository->findAll();
        return $this->json($allCategories, Response::HTTP_OK, [], ['groups' => 'api_category_browse']);
    }

    // function read is able to find all informations about one category and return this with json
    /**
     * @Route("/{id}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(int $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        if (is_null($category)) {
            return $this->getNotFoundResponse();
        }

        return $this->json($category, Response::HTTP_OK, [], ['groups' => 'api_category_browse']);
    }

    private function getNotFoundResponse() {

        $responseArray = [
            'error' => true,
            'userMessage' => 'Ressource non trouvé',
            'internalMessage' => 'Ce category n\'existe pas dans la BDD',
        ];

        return $this->json($responseArray, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
