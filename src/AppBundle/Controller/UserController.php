<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Entity\UserObservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
class UserController extends Controller
{
    /**
     * @Route("/addFavoriteObservation/{id}", name="add_favorite_observation")
     */
    public function addFavoriteObservationAction(Request $request, Observation $observation)
    {
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $user = $this->getUser();
            if(null == $user){
                return $this->redirectToRoute('fos_user_security_login');
            }
            $em = $this->getDoctrine()->getManager();
            $userObservation = new UserObservation();
            $userObservation->setFavoriteObservation(true);
            $userObservation->setObservation($observation);
            $userObservation->setUser($user);

            $em->persist($userObservation);
            $em->flush();
            $this->addFlash('success', 'Cette observation est ajouté dans votre liste d\'observation favorite !');

            return $this->redirectToRoute('observation', array('id' => $observation->getId()));
        }

        return $this->render('AppBundle:Front:add_favorite_observation.html.twig', array(
            'observation' => $observation,
            'form' => $form->createView()
        ));
    }
}
