<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;

class SecurityController extends AbstractController
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

    private $encoder;

    /**
     * SecurityController constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }



}
