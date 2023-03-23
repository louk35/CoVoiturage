<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trajet;
use App\Entity\User;
use App\Entity\Reservation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;

class ReservationController extends AbstractController
{
 
/**
 * @Route("/trajet/{id}/reservation", name="reservation.trajet")
 * @return Response
 * @param Security $security
 * @return RedirectResponse|Response
 * @param Trajet $trajet
 * @param User $user
 * Require ROLE_USER for  method create in this class
 * @IsGranted("ROLE_USER")
 */
public function reserveTrajet(Trajet $trajet, Security $security): Response
{
    
    $user = $security->getUser(); 

    $reservation = new Reservation();
    $reservation->setDateReservation(new \DateTime());
    $reservation->setTrajet($trajet);
    $reservation->addPassager($user);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($reservation);
    $entityManager->flush();

    return $this->render('reservation/confirmation.html.twig', [
    'reservations' => $reservation,
]);

}
}
