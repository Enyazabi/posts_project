<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index(PostRepository $postRepository)
    {
        return $this->render('post/index.html.twig', [
            'post' => $postRepository->findAll(),
        ]);
    }
}
