<?php
/**
 * Created by PhpStorm.
 * User: gboss
 * Date: 26/04/2018
 * Time: 15:33
 */
namespace MyApp\AdminBundle\Controller;
use MyApp\ForumBundle\Entity\Category;
use MyApp\ForumBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ForumAdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('MyAppForumBundle:Post')->findAll();
        $topics = $em->getRepository('MyAppForumBundle:Topic')->findAll();
        $categories = $em->getRepository('MyAppForumBundle:Category')->findAll();


        return $this->render('MyAppAdminBundle:Forum:forumAdmin.html.twig', array(
            'posts' => $posts,
            'topics' => $topics,
            'categories' => $categories
        ));
    }

    public function newCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid()))
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success','Category Created');
            return $this->redirect($this->generateUrl('my_app_admin_forumpage'));
        }

        return $this->render('MyAppAdminBundle:Forum:newCategory.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     *
     * @ParamConverter("category")
     * @param Request $request Symfony\Component\HttpFoundation\Request
     * @param Category $category MyApp\MyAppForumBundle\Entity\Category
     *
     * @return object Symfony\Component\HttpFoundation\RedirectResponse moderator's dashboard
     */
    public function editCategoryAction(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid()))
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success','Category Edit');
            return $this->redirect($this->generateUrl('my_app_admin_forumpage'));
        }

        return $this->render('MyAppAdminBundle:Forum:editCategory.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @ParamConverter("category")
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCategoryAction(Request $request, Category $category)
    {
        $categoryName = $category->getName();
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Category Deleted');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('my_app_admin_forumpage'));
        }else {
            return $this->redirect($this->generateUrl('my_app_admin_forumpage'));
        }
    }
}