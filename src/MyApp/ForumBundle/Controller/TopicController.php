<?php
/**
 * Created by PhpStorm.
 * User: gboss
 * Date: 24/04/2018
 * Time: 18:53
 */

namespace MyApp\ForumBundle\Controller;

use MyApp\ForumBundle\Entity\Category;
use MyApp\ForumBundle\Entity\Topic;
use MyApp\ForumBundle\Form\TopicType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TopicController extends Controller
{
    /**
     * @ParamConverter("category")
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newTopicAction(Request $request, Category $category)
    {

        $topic = new Topic();
        $user = $this->getUser();
        $topic->setUser($user);
        $topic->setCategory($category);

        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid()))
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Topic Created');
            //redirection after topic creation
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('my_app_admin_forumpage'));
            }else {
                return $this->redirect($this->generateUrl('my_app_forum_index'));
            }
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        return $this->render('MyAppAdminBundle:Forum:newTopic.html.twig', array(
            'form' => $form->createView()
        ));}else {
            return $this->render('MyAppForumBundle:Default:newTopic.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    /**
     * @ParamConverter("topic")
     *
     * @param Request $request
     * @param Topic $topic
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editTopicAction(Request $request, Topic $topic)
    {

        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid()))
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success','Topic Edited');

            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('my_app_admin_forumpage'));
            }else {
                return $this->redirect($this->generateUrl('my_app_forum_index'));
            }
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        return $this->render('MyAppAdminBundle:Forum:editTopic.html.twig', array(
            'form' => $form->createView()
        ));}else {
            return $this->render('MyAppForumBundle:Default:editTopic.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    /**
     * @ParamConverter("topic")
     * @param Request $request
     * @param Topic $topic
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteTopicAction(Request $request, Topic $topic)
    {
        $categoryName = $topic->getCategory()->getName();
        $em = $this->getDoctrine()->getManager();
        $em->remove($topic);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Topic Deleted');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('my_app_admin_forumpage', array('name' => $categoryName)));
        }else {
            return $this->redirect($this->generateUrl('my_app_admin_forumpage', array('name' => $categoryName)));
        }
    }
}