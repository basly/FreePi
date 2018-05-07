<?php
/**
 * Created by PhpStorm.
 * User: amira
 * Date: 14/04/2018
 * Time: 18:51
 */

namespace MyApp\JobOwnerBundle\Controller;

use MyApp\JobOwnerBundle\Entity\Payment;
use MyApp\JobOwnerBundle\Form\PaymentType;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;
use MyApp\JobOwnerBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PaymentController extends Controller
{

    /**
     * @ParamConverter("project")
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function PaymentAction(Request $request,Project $project)
    {

        $jobowner = $this->getUser();

        $paid = new Payment();

        $status = 'Paid';
        $paid->setPaidBy($jobowner);
        //$paid->setPaidTo($freelancer);
        $paid->setStatus($status);
        $paid->setProject($project);

        $form = $this->createForm(PaymentType::class, $paid);

        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paid);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Projet Paid');
            //redirection after topic creation
            return $this->redirect($this->generateUrl('project_index'));

        }


//        return $this->render('MyAppJobOwnerBundle:Payment:payment.html.twig', array(
//            'form' => $form->createView(),
//
//        ));

        Stripe::setApiKey("sk_test_lVjCl9mHLScuixIkoFy7DUjx");
        $token = Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 4,
                "exp_year" => 2019,
                "cvc" => "314"
            )

        ));


        $charge = Charge::create(array(
            "amount" => $project->getPrice(),
            "currency" => "usd",
            "source" => $token->id, // obtained with Stripe.js
            "description" => $project->getProjectname()
        ));



        return $this->render('MyAppJobOwnerBundle:Payment:payment.html.twig', array(
            'form' => $form->createView(),

        ));

    }




}
