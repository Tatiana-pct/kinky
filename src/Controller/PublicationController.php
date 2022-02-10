<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Comments;
use App\Entity\Publication;
use App\Form\CommentsType;
use App\Form\PublicationType;
use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publications", name="publication_")
 */
class PublicationController extends AbstractController
{

    //Methode permettant de cree une liste des publications
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


    //Methode permettant de voir le detail d'une publication
    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id,
                            PublicationRepository $publicationRepository,
                            Request $request,
                            EntityManagerInterface $entityManager): Response
    {
        $publication = $publicationRepository->find($id);

        //PARTIE COMMENTAIRE
        //creation du commentaire "vierge"
        $comment = new Comments;

        //implanter la date actuel a l'instance (peu etre fait dans le if)
        $comment->setDateCreated(new \DateTime());

        //on genere le formulaire
        $commentForm = $this->createForm(CommentsType::class,$comment);

        $commentForm->handleRequest($request);

        //traitement du formulaire
        if ($commentForm->isSubmitted()&&$commentForm->isValid()){
            $comment->setPublication($publication);

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('Success', 'votre commentaire a bien été envoyé');
            return $this->redirectToRoute('publication_details', ['id' =>$publication->getId()]);

        }



        return $this->render('publication/details.html.twig',
            [
                "publications"=>$publication,
                'commentForm'=>$commentForm->createView()
            ]);
    }


    //Methode permettant de cree une publication
    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        //creation d'un instance d'une nouvelle publication
        $publication = new Publication();

        //implanter la date actuel a l'instance (peu etre fait dans le if)
        $publication->setDateCreated(new \DateTime());

        //creation du formulaire
        $publicationForm =$this->createForm(PublicationType::class, $publication);
        $publicationForm->handleRequest($request);

        //controler la validation du formulaire
        //traitement du fomulaire
        if($publicationForm->isSubmitted()&&$publicationForm->isValid()){
            $entityManager->persist($publication);
            $entityManager->flush();

            //création du message flash
            $this->addFlash('Success', 'Votre publication a bien été crée!');

            //redirection
            return $this->redirectToRoute('main_home');
        }

        //declanchement de l'affichage
        return $this->render('publication/create.html.twig', [
            'publicationForm'=> $publicationForm->createView()
        ]);
    }



    //Methode teste
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
                                        ex ullam reprehenderit aut sunt voluptas.');
        $publication->setDateCreated(new \DateTime());

        //teste de persistance des données
        //dump($publication);

        //persistance des données en bdd
        $entityManager->persist($publication);
        $entityManager->flush();








        return $this->render('publication/create.html.twig', [

        ]);


    }

    //Methode permettant de modifier une publication
    ///  **
    //   * @Route("/publications", name="publication_modify")
    //   */
    //   public function modify(): Response
    //   {
    //          modify object
    //          $publication->setTitle('hydratationn2');
    //          $entityManager->flush();
    //
    //    return $this->render('publication/delete.html.twig', [
    //       ]);
    //    }



    //Methode permettant de supprimer une publication
    ///  **
    //   * @Route("/publications", name="publication_delete")
    //   */
    //   public function delete(): Response
    //   {
    //      remove object
    //      $entityManager->remove($publication);
    //      $entityManager->flush();
    //    return $this->render('publication/delete.html.twig', [
    //       ]);
    //    }



    public function CreateCommentaire(Request $request, EntityManagerInterface $entityManager):Response
    {
        //creation d'un instance d'un nouveau commentaire
        $commentaire = new Commentaire();

        //implanter la date actuel a l'instance (peu etre fait dans le if)
        $commentaire->setDateCreated(new \DateTime());

        //creation du formulaire
        $commentaireForm=$this->createForm(Commentaire::class, $commentaire);
        $commentaire->handleRequest($request);

        //Controle du traitement et de la validation du formulaire
        if($commentaireForm->isSubmitted()&&$commentaireForm->isValid()){
            $entityManager->persist($commentaire);
            $entityManager->flush();

            //création du message flash
            $this->addFlash('Success', 'Votre publication a bien été crée!');

            //redirection
            return $this->redirectToRoute('main_home');
        }

        //declanchement de l'afficheage
        return $this->render('publication/create.html.twig',
            ['commentaireForm'=>$commentaireForm->createView()]);
    }

}
