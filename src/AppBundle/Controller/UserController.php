<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use AppBundle\Entity\Observation;
use AppBundle\Entity\UserObservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\Type\ObservationType;
use AppBundle\Entity\User;
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

            return $this->redirectToRoute('observations');
        }

        return $this->render('AppBundle:Front:add_favorite_observation.html.twig', array(
            'observation' => $observation,
            'userObservationFavorite' => $userObservationFavorite,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/removeFavoriteObservation/{id}", name="remove_favorite_observation")
     */
    public function removeFavoriteObservationAction(Request $request, Observation $observation)
    {
        $form = $this->get('form.factory')->create();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userObservationFavorite = $em->getRepository('AppBundle:UserObservation')->findUserObservationFavorite($user, $observation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($userObservationFavorite);
            $em->flush();

            $this->addFlash('success', 'Vous avez retirer une observation de vos favoris');

            return $this->redirectToRoute('user_favorite_observations');
        }

        return $this->render('AppBundle:Back:remove_favorite_observation.html.twig', array(
            'observation' => $observation,
            'userObservationFavorite' => $userObservationFavorite,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/user/notifications", name="user_notifications")
     */
    public function showUserNotificationsAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('AppBundle:Notification')->getUserNotifications($user);

        return $this->render('AppBundle:Back:show_notifications.html.twig', compact('notifications', 'user'));
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
    public function showUserObservationAction($id)
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
            $state = $observation->getState();
            $user = $observation->getUser();
            if(true == $state){
                $notification = new Notification();
                $notification->setTitle('Validation de l\'observation : accepté');
                $notification->setDescription('Votre observation a été validé par un de nos naturalistes.');
            }
            else{
                $notification = new Notification();
                $notification->setTitle('Validation de l\'observation : refusé');
                $notification->setDescription('Votre observation n\'a pas été validé par un de nos naturalistes, nous sommes désolé.');
                $em->remove($observation);
            }
            $notification->setUser($user);
            $em->persist($notification);
            $em->flush();

            $this->addFlash('success', 'Vous venez de valider une observation avec succès.');
            return $this->redirectToRoute('observations_to_validate');
        }

        return $this->render('AppBundle:Front:post.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/naturaliste/compte-a-valider", name="account_to_validate")
     */
    public function getRegisterNaturalisteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->getRegisterNaturaliste();

        return $this->render('AppBundle:Back:show_account_to_validate.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/naturaliste/compte-valide/{id}", name="account_to_validate_ok")
     */
    public function validateRegisterNaturalisteAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create();

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $notification = new Notification();
            $notification->setTitle('Validation du compte: accepté');
            $notification->setDescription('Votre compte a été validé par un de nos naturalistes. Vous disposez désormais d\'un compte naturaliste');
            $user->setAccountType(null);
            $user->setRoles(array('ROLE_ADMIN'));
            $user->addNotification($notification);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Vous venez de valider le compte d\'un nouveau naturaliste.');
            return $this->redirectToRoute('account_to_validate');
        }

        return $this->render('AppBundle:Back:allow_naturaliste_account.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @Route("/naturaliste/compte-valide/denied/{id}", name="account_to_validate_denied")
     */
    public function denyRegisterNaturalisteAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create();

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $notification = new Notification();
            $notification->setTitle('Validation du compte: refusé');
            $notification->setDescription('Votre compte n\'a pas été validé par un de nos naturalistes, nous sommes désolé.');
            $user->setAccountType(null);
            $user->setRoles(array('ROLE_USER'));
            $user->addNotification($notification);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Vous venez de refusez la validation d\'un nouveau compte naturaliste.');
            return $this->redirectToRoute('account_to_validate');
        }

        return $this->render('AppBundle:Back:deny_naturaliste_account.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}
