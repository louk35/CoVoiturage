<?php

namespace App\Controller;

use App\Form\RechercheType;
use App\Form\TrajetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trajet;
use App\Repository\TrajetRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class TrajetController extends AbstractController
{
    /**
     * Lister tous les trajets.
     * @Route("/trajet/", name="trajet.list")
     * @return Response
     */
    public function list(): Response
    {
        $trajets = $this->getDoctrine()->getRepository(Trajet::class)->findAll();
        return $this->render('trajet/list.html.twig', [
            'trajets' => $trajets,
        ]);
    }

    /**
     * Chercher et afficher un trajet.
     * @Route("/trajet/{id}", name="trajet.show", requirements={"id" = "\d+"})
     * @param Trajet $trajet
     * @return Response
     */
    public function show(Trajet $trajet): Response
    {
        return $this->render('trajet/show.html.twig', [
            'trajet' => $trajet,
        ]);
    }
    /**
     * Créer un nouveau trajet.
     * @Route("/nouveau-trajet", name="trajet.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     * Require ROLE_USER for  method create in this class
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($trajet);
            $em->flush();
            return $this->redirectToRoute('trajet.list');
        }
        return $this->render('trajet/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * page d'accueil.
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     * @Route("/", name="trajet.search")
     */
    public function search(Request $request, EntityManagerInterface $em) : Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(RechercheType::class, $trajet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lieuDepart = $trajet->getLieuDepart();
            $lieuArrive = $trajet->getLieuArrive();
            $dateDepart =$trajet->getDateDepart();
            if (($lieuDepart != "") && ($lieuArrive != "") && ($dateDepart != "")){
                $trajets = $this->getDoctrine()->getRepository(Trajet::class)->findBy([
                    'lieuDepart' => $lieuDepart,
                    'lieuArrive' => $lieuArrive,
                    'dateDepart' => $dateDepart,
                ]);
                return $this ->render('trajet/search_results.html.twig',  [
                    'trajets' => $trajets,]);
            }
            else {
                $trajets = $this->getDoctrine()->getRepository(Trajet::class)->findAll;
            }

        }
        return $this->render('trajet/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
