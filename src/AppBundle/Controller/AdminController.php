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


/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/dashboard", name="admin_home")
     */
    public function adminHomeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repoObs = $em->getRepository('AppBundle:Observation');
        $repoUsr = $em->getRepository('AppBundle:User');
        $user = $this->getUser();
        $data = [];

        $data['nbObservation'] = $repoObs->countValid();
        $data['observationSubmited'] = $repoObs->getAllSubmittedObservations();
        $data['nbUsers'] = $repoUsr->countAll();
        $data['flashbag'] = false;
        
        return $this->render('AppBundle:Admin:admin.html.twig', ['user' => $user, 'data' => $data]);
    }

    /**
     * @Route("/mailing-list", name="admin_mailing_list")
     */
    public function mailingListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:NewsLetter');
        $user = $this->getUser();
        $data = [];

        $data['mailing'] = $repo->findAll();
        $data['flashbag'] = false;
        
        return $this->render('AppBundle:Admin:mailing_list.html.twig', ['user' => $user, 'data' => $data]);
    }

    /**
     * @Route("/importation-taxref", name="admin_import_taxref")
     */
    public function taxrefImportAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Observation');
        $user = $this->getUser();
        $data = [];

        $data['flashbag'] = false;
        
        return $this->render('AppBundle:Admin:taxref_import.html.twig', ['user' => $user, 'data' => $data]);
    }
}
