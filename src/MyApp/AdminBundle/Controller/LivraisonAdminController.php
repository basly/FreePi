<?php
/**
 * Created by PhpStorm.
 * User: amira
 * Date: 27/04/2018
 * Time: 16:42
 */

namespace MyApp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LivraisonAdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $livraisons = $em->getRepository('FreelancerBundle:Livraison')->findAll();
        $projects = $em->getRepository('MyAppJobOwnerBundle:Project')->findAll();
        $payments = $em->getRepository('MyAppJobOwnerBundle:Payment')->findAll();


        return $this->render('MyAppAdminBundle:Livraison:livraisonAdmin.html.twig', array(
            'livraisons' => $livraisons,
            'projects' => $projects,
            'payments' => $payments
        ));

    }

}