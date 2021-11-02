<?php

namespace App\Controller\Api\V1;

use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function browse(ArtworkRepository $artworkRepository): Response
    {
        $allArtworks = $artworkRepository->findAll();
        return $this->json($allArtworks, Response::HTTP_OK, [], ['groups' => 'api_artwork_browse']);
    }

    // function read is able to find all informations about one artwork and return this with json
    /**
     * @Route("/{id}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(int $id, ArtworkRepository $artworkRepository): Response
    {
        $artwork = $artworkRepository->find($id);

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
