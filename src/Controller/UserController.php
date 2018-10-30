<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function register(Request $request)
    {
        $user = new User();
        $userForm = $this->createForm( UserType::class, $user);

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid())
        {
           $user = $userForm->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($user);
           $em->flush();
        }



        return $this->render('user/register.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }
}

