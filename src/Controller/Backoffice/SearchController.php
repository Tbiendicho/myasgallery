<?php

namespace App\Controller\Backoffice;

use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use App\Repository\EventRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice", name="backoffice_search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/recherche", name="_bar")
     */
    public function searchBar(Request $request, ArtworkRepository $artworkRepository, ArtistRepository $artistRepository, CategoryRepository $categoryRepository, EventRepository $eventRepository): Response
    {
        $search = $request->query->get("search");
        $search = strtolower($search);
        $search = str_replace(' ','-', $search);


        $artwork = $artworkRepository->findOneArtworkWithAllInfos($search);
        $artist = $artistRepository->findOneArtistWithAllInfos($search);
        $category = $categoryRepository->findOneCategoryWithAllInfos($search);
        $event = $eventRepository->findOneEventWithAllInfos($search);

        if ($artwork) {
            return $this->render('backoffice/artwork/read.html.twig', [
            'current_artwork' => $artwork,
            ]);
        } elseif ($artist) {
            return $this->render('backoffice/artist/read.html.twig', [
            'current_artist' => $artist,
            ]);
        } elseif ($category) {
            return $this->render('backoffice/category/read.html.twig', [
            'category' => $category,
            ]);
        } elseif ($event) {
            return $this->render('backoffice/event/read.html.twig', [
            'current_event' => $event,
            ]);
        } else {
            $this->addFlash('danger', 'Aucun résultat trouvé pour la recherche : ' . "{$request->query->get("search")}");
            return $this->redirectToRoute("backoffice_main_show");
        }

    }




    //     $searchForm = $this->createFormBuilder()
    //     ->setAction($this->generateUrl('backoffice_handleSearch'))
    //     ->add('query', TextType::class, [
    //         'attr' => [
    //             'class' => 'form-control',
    //             'placeholder' => 'Recherche'
    //         ]
    //     ])
    //     ->add('recherche', SubmitType::class, [
    //         'attr' => [
    //             'class' => 'btn btn-primary'
    //         ]
    //     ])
    //     ->getForm();

    //     return $this->render('backoffice/search/searchBar.html.twig', [
    //     'search_form' => $searchForm->createView()
    // ]);
    // }

    // /**
    //  * @Route("/handleSearch", name="handleSearch")
    //  */
    // public function handleSearch(Request $request, ArtistRepository $artistRepository)
    // {
    //     $query = $request->request->get('form')['query'];
    //     if($query) {
    //         $artist = $artistRepository->findArtistByName($query);
    //     }
    //     return $this->render('search/searchBar.html.twig', [
    //         'currentArtist' => $artist
    //     ]);
    // }


}
