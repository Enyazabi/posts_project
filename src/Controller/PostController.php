<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{PostRepository};

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     * @param PostRepository $postRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */


    public function index(PostRepository $postRepository)
    {
        return $this->render('post/index.html.twig', [
            'post' => $postRepository->findAll(),
        ]);
    }


    public function createPost($postTitle)
    {

    }
    /**
     * @Route("/post/delete/{id}", name="deletePost")
     */
    public function deletePost(PostRepository $postRepository, $id)
    {
        $post=$postRepository->findOneBy([
            'id'=>$id,
        ]);
        $em=$this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('post');
    }
}
