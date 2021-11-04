<?php

namespace App\Controller\Backoffice;

use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/oeuvre/", name="backoffice_artwork_")
 */
class ArtworkController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(ArtworkRepository $artworkRepository): Response
    {
        return $this->render('backoffice/artwork/browse.html.twig', [
            'artwork_list' => $artworkRepository->findAll(),
        ]);
    }

    /**
     * @Route("{id}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(Artwork $artwork): Response
    {
        return $this->render('backoffice/artwork/read.html.twig', [
            'current_artwork' => $artwork,
        ]);
    }

    /**
     * @Route("edit/{id}", name="edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Artwork $artwork): Response
    {
        // Creation of an artwork form for edit the selected artwork
        $artworkForm = $this->createForm(ArtworkType::class, $artwork);
        
        $artworkForm->handleRequest($request);

        if ($artworkForm->isSubmitted() && $artworkForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $artwork->setUpdatedAt(new DateTimeImmutable());
            $entityManager->flush();

            $this->addFlash('success', "L\'oeuvre `{$artwork->getTitle()}` a bien été mise à jour");

            // Redirecting the user to be sure that the edition was done once
            return $this->redirectToRoute('backoffice_artwork_browse');
        }

        return $this->render('backoffice/artwork/editadd.html.twig', [
            'artwork_form' => $artworkForm->createView(),
            'artwork' => $artwork,
            'page' => 'edit',
        ]);
    }

    /**
     * @Route("add", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request): Response 
    {
        $artwork = new Artwork();

        $artworkForm = $this->createForm(ArtworkType::class, $artwork);
        $artworkForm->handleRequest($request);

        if ($artworkForm->isSubmitted() && $artworkForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artwork);
            $entityManager->flush();

            $this->addFlash('success', "L\'oeuvre `{$artwork->getTitle()}` a bien été ajoutée");

            // Redirecting the user to be sure that the adding was done once
            return $this->redirectToRoute('backoffice_artwork_browse');
        }

        return $this->render('backoffice/artwork/editadd.html.twig', [
            'artwork_form' => $artworkForm->createView(),
            'page' => 'add',
        ]);
    }

        /**
         * @Route("delete/{id}", name="delete", methods={"GET"}, requirements={"id"="\d+"})
         */
        public function delete(Artwork $artwork, EntityManagerInterface $entityManager): Response 
        {
            $entityManager->remove($artwork);
            $entityManager->flush();

            $this->addFlash('success', "L\'oeuvre `{$artwork->getTitle()}` a bien été supprimée");
            
            return $this->redirectToRoute('backoffice_artwork_browse');
        }
}