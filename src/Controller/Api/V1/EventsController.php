<?php

namespace App\Controller\Api\V1;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function browse(EventRepository $eventRepository, Request $request): Response
    {
        $limit = (int) $request->get('limit');
         $random = (int) $request->get('random');
        
         if($limit) {
            $allEvents = $eventRepository->findBy(
                [],
                [],
                $limit
            );
          
         } elseif($random) {
            $allEvents = $eventRepository->findRandom($random);
         } else {
            $allEvents = $eventRepository->findAll();
         }

        return $this->json($allEvents, Response::HTTP_OK, [], ['groups' => 'api_event_browse']);
    }

    /**
     * @Route("/by-date", name="browseByDate", methods={"GET"})
     */
    public function browseByDate(EventRepository $eventRepository, Request $request): Response
    {
        $limit = (int) $request->get('limit');
        $random = (int) $request->get('random');
        
        if($limit) {
            $allEventsByDate = $eventRepository->findEventsByDateWithLimit($limit);
        } elseif($random) {
            $allEventsByDate = $eventRepository->findRandom($random);
        } else {
            $allEventsByDate = $eventRepository->findEventsByDate();
        }

        return $this->json($allEventsByDate, Response::HTTP_OK, [], ['groups' => 'api_event_browse']);
    }


    // function read is able to find all informations about one event and return this with json
    /**
     * @Route("/{slug}", name="read", methods={"GET"})
     */
    public function read(string $slug, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->findBy(["slug" => $slug]);

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
