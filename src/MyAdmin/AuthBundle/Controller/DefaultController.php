<?php

namespace MyAdmin\AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyAdmin\AuthBundle\Form\UserType;
use MyAdmin\AuthBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function loginAction()
    {
       $helper = $this->get('security.authentication_utils');

       return $this->render(
           'AuthBundle:Default:login.html.twig',
           array(
               'last_username' => $helper->getLastUsername(),
               'error'         => $helper->getLastAuthenticationError(),
           )
       );
    }

    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setRole('ROLE_ADMIN');

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'AuthBundle:Default:register.html.twig',
            array('form' => $form->createView())
        );
    }
}
