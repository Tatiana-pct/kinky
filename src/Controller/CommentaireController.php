<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaires"), name="commentaire_"
 */
class CommentaireController extends AbstractController
{

    //Methode affichant la liste des commentaire
    /**
     * @Route("", name="list")
     */
    public function list(CommentaireRepository $commentaireRepository)
    {
        $commentaire = $commentaireRepository->findAll();
        return $this->render('publication/list.html.twig');

    }

    //Methode permettant de cree un commentaire
    /**
     * @Route("/create", name="create")
     */
    public function Create(Request $request, EntityManagerInterface $entityManager):Response
    {
        //creation d'un instance d'un nouveau commentaire
        $commentaire = new Commentaire();

        //implanter la date actuel a l'instance (peu etre fait dans le if)
        $commentaire->setDateCreated(new \DateTime());

        //creation du formulaire
        $commentaireForm=$this->createForm(CommentaireType::class,$commentaire);
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