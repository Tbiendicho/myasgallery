<?php

namespace App\Controller\Api\V1;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// creating a global route for events BREAD
/**
 * @Route("/api/v1/evenement", name="api_v1_events_")
 */
class EventsController extends AbstractController
{
    // function browse is able to find a list of all events and return this with json
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(EventRepository $eventRepository): Response
    {
        $allEvents = $eventRepository->findAll();
        return $this->json($allEvents, Response::HTTP_OK, [], ['groups' => 'api_event_browse']);
    }

    /**
     * @Route("/by-date", name="browseByDate", methods={"GET"})
     */
    public function browseByDate(EventRepository $eventRepository): Response
    {
        $allEventsByDate = $eventRepository->findEventsByDate();
        return $this->json($allEventsByDate, Response::HTTP_OK, [], ['groups' => 'api_event_browse']);
    }


    // function read is able to find all informations about one event and return this with json
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
