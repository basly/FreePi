<?php
/**
 * Created by PhpStorm.
 * User: gboss
 * Date: 25/04/2018
 * Time: 19:46
 */

namespace MyApp\ForumBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ForumController extends Controller
{
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getManager()
            ->getRepository('MyApp\ForumBundle\Entity\Category')
            ->findAll();

        $topics = $this->getDoctrine()->getManager()
            ->getRepository('MyApp\ForumBundle\Entity\Topic')
            ->findAll();

        return $this->render('@MyAppForum/Default/forumIndex.html.twig',
            array(
                'categories' => $categories,
                'topics' => $topics)
        );
    }

    

}