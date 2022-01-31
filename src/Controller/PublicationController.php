<?php

namespace App\Controller;

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
    public function list(): Response
    {
        //todo: aller chercher les publications en BDD
        return $this->render('publication/list.html.twig', [

        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id): Response
    {

        //todo: aller chercher la serie dans la BDD
        return $this->render('publication/details.html.twig', [

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


    ///  **
    //   * @Route("/publications", name="publication_delete")
    //   */
    //   public function delete(): Response
    //   {
    //    return $this->render('publication/delete.html.twig', [
    //       ]);
    //    }



}
