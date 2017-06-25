<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Observation;
use AppBundle\Entity\NewsLetter;
use AppBundle\Entity\Taxref;
use AppBundle\Form\Type\NewsLetterType;
use AppBundle\Form\Type\TaxrefImportType;
use AppBundle\Form\Type\ObservationType;
use AppBundle\Entity\ObservationFilter;
use AppBundle\Form\Type\ObservationFilterType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;


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
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Observation');
        $user = $this->getUser();
        $data = [];

        $data['flashbag'] = false;

        $form = $this->get('form.factory')->create(TaxrefImportType::class);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $csv = $form['attachment']->getData();
            $data['csv'] = $serializer->decode(file_get_contents($csv), 'csv');;
            // Turning off doctrine default logs queries for saving memory
            $em->getConnection()->getConfiguration()->setSQLLogger(null);
            $size = count($data['csv']);
            $batchSize = 20;
            $i = 1;

            var_dump($csv);
            die();

            /*
            // Processing on each row of data
            foreach($data as $row) {
                $taxref = $em->getRepository('AppBundle')
                           ->findOneByReference($row['reference']);
                             
                // If the taxref doest not exist we create one
                if(!is_object($taxref)){
                    $taxref = new Taxref();
                    $taxref->setReference($row['reference']);
                }
                
                // Updating info
                $taxref->setLastName($row['lastname']);
                $taxref->setFirstName($row['firstname']);
                
                // Do stuff here !
        
                // Persisting the current user
                $em->persist($taxref);
                
                // Each 20 users persisted we flush everything
                if (($i % $batchSize) === 0) {
     
                    $em->flush();
                    // Detaches all objects from Doctrine for memory save
                    $em->clear();
                }
                $i++;
            }          
            // Flushing and clear data on queue
            $em->flush();
            $em->clear();
        
            return $this->redirectToRoute('admin_import_taxref');*/
        }
        
        return $this->render('AppBundle:Admin:import_taxref.html.twig', ['user' => $user, 'data' => $data, 'form' => $form->createView()]);
    }

    /**
     * @Route("/export-mailing-list", name="admin_export_mailing_list")
     */
    public function generateCsvAction(Request $request)
    {
        //Connexion à la base de données avec le service database_connection
        $conn = $this->get('database_connection');
        $results = $conn->query( "SELECT * FROM news_letter" );
        $response = new StreamedResponse();

        $response->setCallback(function() use($results){
            $handle = fopen('php://output', 'w+');
            fputcsv($handle, array('Prénom',
                                     'Email',
                    ),';');
                    
            while( $row = $results->fetch() ) 
               {
                    fputcsv($handle,array($row['prenom'],
                                          $row['email'],
                           ),';');
               }
               
            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition','attachment; filename="export_mailing-list.csv"');
          
        return $response;                             
    }
}
