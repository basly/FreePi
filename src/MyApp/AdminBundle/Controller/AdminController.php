<?php

namespace MyApp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Replyreclamation;
use AppBundle\Form\ReplyreclamationType;
use AppBundle\Entity\Reclamation;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ReclamationType;

class AdminController extends Controller
{
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('MyAppForumBundle:Post')->findAll();
        $topics = $em->getRepository('MyAppForumBundle:Topic')->findAll();


        $role1='%ROLE_FREELANCER%';
        $freelancers = $em->getRepository("FreelancerBundle:User")->createQueryBuilder('u1')
            ->where('u1.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role1.'"%')
            ->getQuery()
            ->getResult();

        $role2='%ROLE_JOBOWNER%';
        $jobowners = $em->getRepository("FreelancerBundle:User")->createQueryBuilder('u2')
            ->where('u2.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role2.'"%')
            ->getQuery()
            ->getResult();

        return $this->render('MyAppAdminBundle:Default:Admin_home.html.twig', array(
            'projects' => $projects,
            'topics' => $topics,
            'freelancers' => $freelancers,
            'jobowners' => $jobowners
        ));
    }
    public function ShowReclamationsAction()
    {

        $ty="Reclamation";
        $parameters = array(
            'ty' => $ty,
            'created'=>"Created",
            'inprogress'=>"InProgress"
        );

        $dql = 'SELECT u
    FROM AppBundle:Reclamation u
    WHERE u.type =:ty AND (u.statue= :created or u.statue=:inprogress
    )
   ';

        $query1 = $this->getDoctrine()->getEntityManager()->createQuery($dql)
            ->setParameters($parameters);
        $reclamations = $query1->getResult();
        return $this->render('@MyAppAdmin/Default/Reclamations.html.twig',array('reclamations' =>   $reclamations));
    }
    public function showReclamationAction(Request $request,$id)
    {

        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM FreelancerBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_ADMIN"%');

        $admin = $query->getResult();
        $parameters = array(
            'idreclamation' => $id
        );

        $dql = 'SELECT u
    FROM AppBundle:Replyreclamation u
    WHERE u.idreclamation=:idreclamation 
    
   ';

        $query1 = $this->getDoctrine()->getEntityManager()->createQuery($dql)
            ->setParameters($parameters);


        $replys = $query1->getResult();

        $reclamation = $this->getDoctrine()->getRepository('AppBundle:Reclamation')->find($id);
        $user = $this->getDoctrine()->getRepository('FreelancerBundle:User')->find($reclamation->getIduser());
        $reply=new Replyreclamation();
        $form=$this->createForm(ReplyreclamationType::class, $reply);
        $formview =$form->createView();
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid())
        {
            $save=$this->getDoctrine()->getManager();
            $this->get('session')->getFlashBag()->add(
                'notice','Reclamation sended to administrator'
            );
            $reply->setIduser($this->getUser()->getId());
            $reply->setIdreclamation($id);
            $save->persist($reply);
            $save->flush();

            return $this->render('@MyAppAdmin/Default/showReclamation.html.twig', array('rec' =>$reclamation,'form'=>$formview,'replys'=>$replys,'admin'=>$admin,'user'=>$user));

        }

        return $this->render('@MyAppAdmin/Default/showReclamation.html.twig', array('rec' =>$reclamation,'form'=>$formview,'replys'=>$replys,'admin'=>$admin,'user'=>$user));
    }

}
