<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Observation;
use AppBundle\Entity\NewsLetter;
use AppBundle\Form\Type\NewsLetterType;
use AppBundle\Form\Type\ObservationType;
use AppBundle\Entity\ObservationFilter;
use AppBundle\Form\Type\ObservationFilterType;

class AppController extends Controller
{
    /**
     * @Route("/", name="startpage")
     */
    public function starterAction(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED') == true) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Front:startpage.html.twig');
    }

    /**
     * @Route("/accueil", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Front:index.html.twig');
    } 

    /**
     * @Route("/observations/", name="observations")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Observation');
        $paginator  = $this->get('knp_paginator');
        $observationFilter = new ObservationFilter();

        $query = $repo->getAllValidObservations();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5,/*limit per page*/
            ['wrap-queries' => true]
        );

        $form = $this->get('form.factory')->create(ObservationFilterType::class, $observationFilter);

        return $this->render('AppBundle:Front:list.html.twig', ['pagination' => $pagination,'form' => $form->createView()]);
    }

    /**
     * @Route("/observations_filtre/", name="observations_filter")
     */
    public function listFilteredAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Observation');
        $observationFilter = new ObservationFilter();
        $paginator  = $this->get('knp_paginator');

        $form = $this->get('form.factory')->create(ObservationFilterType::class, $observationFilter, [
            'action' => $this->generateUrl('observations_filter'),
            'method' => 'GET',]
        );

        if ($request->isMethod('GET') && $form->handleRequest($request)->isValid()) {
            $pagination = $paginator->paginate(
                $repository->search($observationFilter->toArray()),
                $request->query->getInt('page', 1),
                5,/*limit per page*/
                ['wrap-queries' => true]
            );
        }

        return $this->render('AppBundle:Front:list.html.twig', ['pagination' => $pagination, 'form' => $form->createView()]);
    }

    /**
     * @Route("/observation/{id}", name="observation")
     */
    public function showAction(Request $request)
    {
        $routeParams = $request->attributes->get('_route_params');
        $id = $routeParams['id'];

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation');
        $observation = $repository->find($id);

        return $this->render('AppBundle:Front:show.html.twig', compact('observation'));
    }

    /**
     * @Route("/participer/", name="participate")
     */
    public function postAction(Request $request)
    {
        $user = $this->getUser();
        if(null == $user){
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $observation = new Observation();

        $form = $this->get('form.factory')->create(ObservationType::class, $observation, ['role' => $this->getUser()->getRoles()]);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
                $this->addFlash('success', 'Votre observation a été ajouté avec succès !');
            }
            else{
                $observation->setState(false);
                $this->addFlash('success', 'Votre observation a été enregistrée. Celle-ci est en attente de validation.');
            }
            $observation->setUser($user);
            $em->persist($observation);
            $em->flush();

            return $this->redirectToRoute('user_observations');
        }

        return $this->render('AppBundle:Front:post.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/carte-interactive/", name="map")
     */
    public function mapAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation');
        $observationFilter = new ObservationFilter();

        $form = $this->get('form.factory')->create(ObservationFilterType::class, $observationFilter);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $observations = $repository->search($observationFilter->toArray())->getResult();

            return $this->render('AppBundle:Front:map.html.twig', ['observations' => $observations, 'form' => $form->createView()]);
        }

        return $this->render('AppBundle:Front:map.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/carte-interactive/{id}", name="map_observe")
     */
    public function mapObserveAction(Request $request)
    {
        $routeParams = $request->attributes->get('_route_params');
        $id = $routeParams['id'];

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation');
        $observation = $repository->find($id);

        return $this->render('AppBundle:Front:map_observe.html.twig', compact('observation'));
    }

    /**
     * @Route("/faq/", name="faq")
     */
    public function faqAction(Request $request)
    {
        return $this->render('AppBundle:Front:faq.html.twig');
    }

    /**
     * @Route("/a-propos/", name="about")
     */
    public function aboutAction(Request $request)
    {
        
        return $this->render('AppBundle:Front:about.html.twig');
    }

    /**
     * @Route("/inscription_newsletter/", name="register_newsletter")
     */
    public function registerNewsAction(Request $request)
    {
        $newsLetter = new NewsLetter(
            $request->query->get('name'),
            $request->query->get('email')
        );
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:NewsLetter');

        $form = $this->get('form.factory')->create(NewsLetterType::class, $newsLetter, [
            'action' => $this->generateUrl('register_newsletter'),
            'method' => 'GET',]
        );

        if ($request->isMethod('GET') && $form->handleRequest($request)->isValid()) {
            if ($repo->findOneByMail($newsLetter->getMail())) {
                $request->getSession()->getFlashBag()->add('warning','Vous êtes déjà inscrit à la newsletter.');

                return new Response('Vous êtes déjà inscrit à la newsletter.');
            } else {
                $em->persist($newsLetter);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info','Inscription à la newsletter bien effectuée.');
                return new Response('Inscription à la newsletter bien effectuée.');
            }
        } else {
            return $this->render('AppBundle:Front:newsletter.html.twig', ['form' => $form->createView()]);
        }
    }
}
