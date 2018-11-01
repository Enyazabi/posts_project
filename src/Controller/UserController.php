<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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


    /**
     * @Route("/userlist", name="userlist", methods="GET")
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userList(UserRepository $userRepository)
    {
        $userForm = $this->createForm(UserType::class);
        return $this->render('user/userlist.html.twig', [
            'user' => $userRepository->findAll(),
            'userForm'=>$userForm->createView(),
        ]);
    }

    /**
     * @Route("/userlist/{id}", name="deleteUser")
     * @param UserRepository $userRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUser(UserRepository $userRepository, $id)
    {
        $user=$userRepository->findOneBy([
            'id'=>$id,
        ]);
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('userlist');
    }


}

