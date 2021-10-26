<?php

namespace App\Controller\Api\V1;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/evenement", name="api_v1_events_")
 */
class EventsController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(EventRepository $eventRepository): Response
    {
        $allEvents = $eventRepository->findAll();
        return $this->json($allEvents, Response::HTTP_OK, [], ['groups' => 'api_event_browse']);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(int $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        if (is_null($event)) {
            return $this->getNotFoundResponse();
        }

        return $this->json($event, Response::HTTP_OK, [], ['groups' => 'api_event_browse']);
    }

    private function getNotFoundResponse() {

        $responseArray = [
            'error' => true,
            'userMessage' => 'Ressource non trouvé',
            'internalMessage' => 'Ce event n\'existe pas dans la BDD',
        ];

        return $this->json($responseArray, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
