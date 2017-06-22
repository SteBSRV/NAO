<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Entity\UserObservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\Type\ObservationType;
class UserController extends Controller
{
    /**
     * @Route("/addFavoriteObservation/{id}", name="add_favorite_observation")
     */
    public function addFavoriteObservationAction(Request $request, Observation $observation)
    {
        $form = $this->get('form.factory')->create();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userObservationFavorite = $em->getRepository('AppBundle:UserObservation')->findUserObservationFavorite($user, $observation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            if(null == $user){
                return $this->redirectToRoute('fos_user_security_login');
            }
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
            'userObservationFavorite' => $userObservationFavorite,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/user/mes-observations", name="user_observations")
     */
    public function showAllUserObservationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $observations = $em->getRepository('AppBundle:Observation')->getUserObservations($user);

        return $this->render('AppBundle:Back:user_observations.html.twig', compact('observations'));
    }

    /**
     * @Route("/user/observation/{id}", name="user_observation")
     */
    public function showUserObservationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository('AppBundle:Observation')->find($id);

        return $this->render('AppBundle:Front:show.html.twig', compact('observation'));
    }

    /**
     * @Route("/user/mes-observations-favorites", name="user_favorite_observations")
     */
    public function showFavoriteObservationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $observations = $em->getRepository('AppBundle:Observation')->getUserFavoriteObservations($user->getId());

        return $this->render('AppBundle:Back:user_favorite_observations.html.twig', compact('observations'));
    }

    /**
     * @Route("/naturaliste/observations-a-valider", name="observations_to_validate")
     */
    public function showInvalidObservationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('AppBundle:Observation')->getAllSubmittedObservations();

        return $this->render('AppBundle:Back:show_observations_to_validate.html.twig', compact('observations'));
    }

    /**
     * @Route("/naturaliste/observations-a-valider/edit/{id}", name="edit_observations_to_validate")
     */
    public function editInvalidObservationsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository('AppBundle:Observation')->find($id);

        $form = $this->get('form.factory')->create(ObservationType::class, $observation, ['role' => $this->getUser()->getRoles()]);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($observation);
            $em->flush();
            
            return $this->redirectToRoute('observation', compact('id','observation'));
        }

        return $this->render('AppBundle:Front:post.html.twig', ['form' => $form->createView()]);
    }
}
