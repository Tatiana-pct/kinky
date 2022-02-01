<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publications", name="publication_")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(PublicationRepository $publicationRepository): Response
    {

        $publication = $publicationRepository->findBestPublication();
        return $this->render('publication/list.html.twig', [
            "publications"=>$publication

        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id, PublicationRepository $publicationRepository): Response
    {
        $publication = $publicationRepository->find($id);

        return $this->render('publication/details.html.twig', [
            "publications"=>$publication

        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(): Response
    {
        return $this->render('publication/create.html.twig', [

        ]);
    }

    /**
     * @Route("/demo", name="em-demo")
     */
    public function demo(EntityManagerInterface $entityManager): Response
    {
        //creation de l'instatence de l'entité publication
        $publication = new Publication();

        //hydratattion de toustes les propietés
        $publication->setTitle('hydratation2');
        $publication->setPublication('

            Lorem ipsum dolor sit amet. 
            Qui eveniet deserunt ut ullam labore ut voluptas consequatur quo quia nihil.
            Qui quas dignissimos aut quia nisi ut pariatur fugiat aut dolorem iure eos 
            iste molestias aut quod labore et facere aspernatur.
            Et voluptas dicta ut ratione dolorem ut ullam accusantium aut assumenda
            exercitationem! Et eius pariatur aut excepturi maiores qui itaque adipisci
            ut perspiciatis cumque ut quis quisquam ut aliquam dolores sed galisum sint.
            Ab veniam expedita qui exercitationem animi est impedit velit ut quod internos
            ad voluptate sequi. Aut internos consequatur in quia voluptatem aut eius fugit
            ex ullam reprehenderit aut sunt voluptas.
 ');
        $publication->setDateCreated(new \DateTime());

        //teste de persistance des données
        //dump($publication);

        //persistance des données en bdd
        $entityManager->persist($publication);
        $entityManager->flush();

        //remove object
        //$entityManager->remove($publication);
        //$entityManager->flush();


        //modify object
        //$publication->setTitle('hydratationn2');
        //$entityManager->flush();

        return $this->render('publication/create.html.twig', [

        ]);
    }


    ///  **
    //   * @Route("/publications", name="publication_delete")
    //   */
    //   public function delete(): Response
    //   {
    //    return $this->render('publication/delete.html.twig', [
    //       ]);
    //    }



}
