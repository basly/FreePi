<?php
/**
 * Created by PhpStorm.
 * User: amira
 * Date: 27/04/2018
 * Time: 15:39
 */

namespace MyApp\FreelancerBundle\Controller;

use MyApp\FreelancerBundle\Entity\Livraison;
use MyApp\FreelancerBundle\Form\LivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Filesystem\Filesystem;
//use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class LivraisonController extends Controller
{


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newLivraisonAction(Request $request)
    {

        //$fs = new Filesystem();

//        try {
//            $fs->mkdir('C:\test'.'Amira');
//        } catch (IOExceptionInterface $e) {
//            echo "An error occurred while creating your directory at ".$e->getPath();
//        }

        $user = $this->getUser();
        $livraison = new Livraison();

        $status = 'livred';
        $livraison->setLivredBy($user);
        $livraison->setStatus($status);

        $form = $this->createForm(LivraisonType::class, $livraison);

        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid()))
        {
            //$ps = $livraison->getPieceJointe();
            $em = $this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success','Livred');
            //$fs->copy($ps, 'C:\wamp64\www\2404\livred\\');
            return $this->redirect($this->generateUrl('freelancer_homepage'));
        }

        return $this->render('FreelancerBundle:Livraison:newLivraison.html.twig', array(
            'form' => $form->createView()
        ));
    }


}