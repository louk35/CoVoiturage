<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservation;
use App\Entity\Trajet;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="mes.reservations")
     * @return Response
     * @param Security $security
     * @return RedirectResponse|Response
     * Require ROLE_USER for  method create in this class
     * @IsGranted("ROLE_USER")
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        $reservations = $this->getDoctrine()->getRepository(Reservation::class)->findBy(['passager' => $user]);
        return $this->render('reservation/mesreservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }
    /**
     * Affiche détail de la réservation
     * @Route("/reservation/{id}", name="reservation.show", methods="GET")
     * @param Reservation $reservation
     * @return Response
     */
    public function show(Reservation $reservation) : Response 
    {
    return $this->render('reservation/show.html.twig', [
    'reservation' => $reservation,
    ]);
    }

    /**
     * Supprimer une réservation à vous.
     * @Route("reservations/{id}/delete", name="mes.reservations.delete")
     * @return Response
     * @param Request $request
     * @param Security $security
     * @param Reservation $reservation
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     * Require ROLE_USER for  method create in this class
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('mes.reservations.delete', ['id' => $reservation->getId()]))
            ->getForm();
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('reservation/delete.html.twig', [
                'reservation' => $reservation,
                'form' => $form->createView(),
            ]);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('mes.reservations');
    }
    /**
     * Reserver un trajet
     * @Route("/reservation-trajet/", name="reservation.trajet")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Security $security
     * @return RedirectResponse|Response
     * Require ROLE_USER for  method create in this class
     * @IsGranted("ROLE_USER")
     */
    public function Reserver(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $reservation = new Reservation();
        $trajet_id = $_GET['trajet_id'];
        $user = $security->getUser();
            if ($user) {
                $reservation->setPassager($user);
                $reservation->setTrajet($trajet_id);
            }
            $em->persist($reservation);
            $em->flush();

        
        return $this->render('reservation/confirmation.html.twig', [
            'reservation' => $reservation,
            ]);
    }
}


