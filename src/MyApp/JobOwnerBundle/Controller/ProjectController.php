<?php

namespace MyApp\JobOwnerBundle\Controller;

use MyApp\JobOwnerBundle\Entity\Examen;
use MyApp\JobOwnerBundle\Entity\Project;
use MyApp\FreelancerBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Project controller.
 *
 */
class ProjectController extends Controller
{
    /**
     * Lists all project entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('MyAppJobOwnerBundle:Project')->findAll();
        $paginator  = $this->get('knp_paginator');

        $result= $paginator->paginate(
          $projects,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5)

        );
        return $this->render('MyAppJobOwnerBundle:project:indexAllProject.html.twig', array(
            'projects' => $result,
        ));
    }

    /**
     * Lists project entities actuel user.
     *
     */
    public function indexUserProjectAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $projects = $em->getRepository('MyAppJobOwnerBundle:Project')->findBy(array("jobowner"=>$user));
        $paginator  = $this->get('knp_paginator');

        $result= $paginator->paginate(
            $projects,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5)

        );
        return $this->render('MyAppJobOwnerBundle:project:index.html.twig', array(
            'projects' => $result,
        ));
    }

    /**
     * Creates a new project entity.
     *
     */
    public function newAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm('MyApp\JobOwnerBundle\Form\ProjectType', $project);
        $form->handleRequest($request);
        $user = $this->getUser();
        $project->setJobowner($user);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('project_show', array('id' => $project->getId()));
        }

        return $this->render('MyAppJobOwnerBundle:project:new.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a project entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('MyAppJobOwnerBundle:Project')->find($id);
        $deleteForm = $this->createDeleteForm($project);


        $user = $this->getUser();

        $free = $em->getRepository('FreelancerBundle:User')->findAll();
        $freelancer = new User();
        foreach ($free as $freel){
            $freelancer = $freel;
        }

        $exs = $em->getRepository('MyAppJobOwnerBundle:Examen')->findBy(array("project"=>$project));
        $examen = new Examen();
        foreach($exs as $e){
            $examen = $e;
        }



        $test = $this->getDoctrine()
            ->getRepository('MyAppJobOwnerBundle:Tests')
            ->findBy(array('freelancer' => $user,'examen'=>$examen));

        $nb = count($test);
        var_dump($nb);



        return $this->render('MyAppJobOwnerBundle:project:show.html.twig', array(
            'project' => $project,'examen'=>$examen,'test' => $nb,'free'=>$user,'project'=>$project,'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing project entity.
     *
     */
    public function editAction(Request $request, Project $project)
    {
        $deleteForm = $this->createDeleteForm($project);
        $editForm = $this->createForm('MyApp\JobOwnerBundle\Form\ProjectType', $project);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_edit', array('id' => $project->getId()));
        }

        return $this->render('MyAppJobOwnerBundle:project:edit.html.twig', array(
            'project' => $project,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a project entity.
     *
     */
    public function deleteAction(Request $request, Project $project)
    {
        $form = $this->createDeleteForm($project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
        }

        return $this->redirectToRoute('project_index');
    }

    /**
     * Creates a form to delete a project entity.
     *
     * @param Project $project The project entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Project $project)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('id' => $project->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
