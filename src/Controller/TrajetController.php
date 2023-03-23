<?php

namespace App\Controller;

use App\Form\RechercheType;
use App\Form\TrajetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trajet;
use App\Entity\Reservation;
use App\Repository\TrajetRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;


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
     * Lister les trajets creer.
     * @Route("/mes-trajets/", name="mes.trajets")
     * @return Response
     * @param Security $security
     * @return RedirectResponse|Response
     * Require ROLE_USER for  method create in this class
     * @IsGranted("ROLE_USER")
     */
    public function list_mes_trajets(Security $security): Response
    {
        $user = $security->getUser();
        $trajets = $this->getDoctrine()->getRepository(Trajet::class)->findBy(['conducteur' => $user]);
        return $this->render('trajet/mestrajets.html.twig', [
            'trajets' => $trajets,
        ]);
    }
    /**
     * Éditer un trajet à vous.
     * @Route("mes-trajets/{id}/edit", name="mes.trajets.edit")
     * @return Response
     * @param Request $request
     * @param Security $security
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     * Require ROLE_USER for  method create in this class
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Trajet $trajet, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('mes.trajets');
        }
        return $this->render('trajet/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Supprimer un trajet à vous.
     * @Route("mes-trajets/{id}/delete", name="mes.trajets.delete")
     * @return Response
     * @param Request $request
     * @param Security $security
     * @param Trajet $trajet
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     * Require ROLE_USER for  method create in this class
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Trajet $trajet, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('mes.trajets.delete', ['id' => $trajet->getId()]))
            ->getForm();
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('trajet/delete.html.twig', [
                'trajet' => $trajet,
                'form' => $form->createView(),
            ]);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($trajet);
        $em->flush();
        return $this->redirectToRoute('mes.trajets');
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
     * @param Security $security
     * @return RedirectResponse|Response
     * Require ROLE_USER for  method create in this class
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();
            if ($user) {
                $trajet->setConducteur($user);
            }
            $em->persist($trajet);
            $em->flush();
            return $this->redirectToRoute('mes.trajets');
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
    public function search(Request $request, EntityManagerInterface $em): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(RechercheType::class, $trajet);
        $form->handleRequest($request);
        $trajets = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $lieuDepart = $trajet->getLieuDepart();
            $lieuArrive = $trajet->getLieuArrive();
            $dateDepart = $trajet->getDateDepart();

            if (($lieuDepart != "") && ($lieuArrive != "") && ($dateDepart != "")) {
                $trajets = $this->getDoctrine()->getRepository(Trajet::class)->findByDate($lieuDepart, $lieuArrive, $dateDepart);
                return $this->render('trajet/search_results.html.twig', [
                    'trajets' => $trajets,
                ]);
            }
        }
        return $this->render('trajet/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
