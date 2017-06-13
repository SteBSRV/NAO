<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('AppBundle:Front:list.html.twig');
    }

    /**
     * @Route("/observations/{id}", name="observation")
     */
    public function showAction(Request $request)
    {
        return $this->render('AppBundle:Front:show.html.twig');
    }

    /**
     * @Route("/participer/", name="participate")
     */
    public function postAction(Request $request)
    {
        return $this->render('AppBundle:Front:post.html.twig');
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
