<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Observation;
use AppBundle\Form\Type\ObservationType;

class AppController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Front:index.html.twig');
    }

    /**
     * @Route("/observations/page-{page}", name="observations", requirements={"page": "\d+"})
     */
    public function listAction(Request $request, $page = 1)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation');
        $observations = $repository->findAll();

        return $this->render('AppBundle:Front:list.html.twig', compact('observations'));
    }

    /**
     * @Route("/observations/{id}", name="observation")
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
        $em = $this->getDoctrine()->getManager();
        $observation = new Observation();

        $form = $this->get('form.factory')->create(ObservationType::class, $observation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($observation);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info','Observation bien ajoutée.');
            $id = $observation->getId();
            return $this->redirectToRoute('observation', compact('id','observation'));
        }


        return $this->render('AppBundle:Front:post.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/carte-interactive/", name="map")
     */
    public function mapAction(Request $request)
    {
        return $this->render('AppBundle:Front:map.html.twig');
    }

    /**
     * @Route("/faq/", name="faq")
     */
    public function faqAction(Request $request)
    {
        return $this->render('AppBundle:Front:faq.html.twig');
    }

    /**
     * @Route("/mon_compte/", name="account")
     */
    public function accountAction(Request $request)
    {
       
    }

    /**
     * @Route("/logout/", name="logout")
     */
    public function logoutAction(Request $request)
    {
        
    }
}
