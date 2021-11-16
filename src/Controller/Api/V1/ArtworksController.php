<?php

namespace App\Controller\Api\V1;

use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// creating a global route for Artworks BREAD
/**
 * @Route("/api/v1/oeuvre", name="api_v1_artworks_")
 */
class ArtworksController extends AbstractController
{
    // function browse is able to find a list of all artworks and return this with json
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(ArtworkRepository $artworkRepository, Request $request): Response
    {
        $limit = (int) $request->get('limit');
        $random = (int) $request->get('random');
       
        if($limit) {
           $allArtworks = $artworkRepository->findBy(
               [],
               [],
               $limit
           );
         
        } elseif($random) {
           $allArtworks = $artworkRepository->findRandom($random);
        } else {
           $allArtworks = $artworkRepository->findAll();
        }

        return $this->json($allArtworks, Response::HTTP_OK, [], ['groups' => 'api_artwork_browse']);
    }

    /**
     * @Route("/categorie/{slug}", name="api_artwork_browse_by_category", methods={"GET"})
     */
    public function browseByCategory(string $slug, ArtworkRepository $artworkRepository, Request $request): Response
    {
        $limit = (int) $request->get('limit');
        $random = (int) $request->get('random');
        
        if($limit) {
            $artworksByCategory = $artworkRepository->findArtworksFromCategoryWithLimit($limit, $slug);
        } elseif($random) {
            $artworksByCategory = $artworkRepository->findRandomArtworkByCategory($random, $slug);
        } else {
            $artworksByCategory = $artworkRepository->findArtworksFromOneCategory($slug);
        }

        return $this->json($artworksByCategory, Response::HTTP_OK, [], ['groups' => 'api_artwork_browse_by_category']);
    }

    // function read is able to find all informations about one artwork and return this with json
    /**
     * @Route("/{slug}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(string $slug, ArtworkRepository $artworkRepository): Response
    {
        $artwork = $artworkRepository->find($slug);

        if (is_null($artwork)) {
            return $this->getNotFoundResponse();
        }

        return $this->json($artwork, Response::HTTP_OK, [], ['groups' => 'api_artwork_browse']);
    }

    private function getNotFoundResponse() {

        $responseArray = [
            'error' => true,
            'userMessage' => 'Ressource non trouvé',
            'internalMessage' => 'Ce artwork n\'existe pas dans la BDD',
        ];

        return $this->json($responseArray, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
