<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LearningController extends AbstractController
{
    /**
     * @Route("/about-becode", name="about")
     * @param SessionInterface $session
     * @return Response
     */
    public function aboutMe(SessionInterface $session): Response
    {
        if ($session->get('name')) {
            return $this->render('learning/about-me.html.twig', ['name' => $session->get('name')]);
        }
        return $this->forward('App\Controller\LearningController::showMyName');
    }

    /**
     * @Route("/", name="show-name")
     * @param SessionInterface $session
     * @return Response
     */
    public function showMyName(SessionInterface $session): Response
    {
        if ($session->get('name')) {
            $name = $session->get('name');
        } else {
            $name = 'unknown';
        }
        $user = new User();
        //create a form
        $form = $this->createFormBuilder($user)
            ->setAction($this->generateUrl('change-name'))
            ->setMethod('POST')
            //create input type text
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'Enter your name', 'class' => 'w-50 text-center mb-2']
            ])
            //create input type submit button
            ->add('save', SubmitType::class, ['label' => 'Add', 'attr' => ['class' => 'btn btn-primary w-50']])
            ->getForm();
        //return the form view
        return $this->render('learning/show-myname.html.twig', [
            'name' => $name,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/changeName", name="change-name")
     * @param Request $request
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function changeMyName(Request $request, SessionInterface $session): RedirectResponse
    {
        $form = $request->request->get('form');
        $user = new User();
        $user->setName($form['name']);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        $session->set('name', $form['name']);
        return $this->redirectToRoute('show-name');
    }
}