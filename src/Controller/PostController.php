<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{PostRepository};

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post", methods="GET")
     * @param PostRepository $postRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */


    public function index(PostRepository $postRepository)
    {
        $postForm = $this->createForm(PostType::class);
        return $this->render('post/index.html.twig', [
            'post' => $postRepository->findAll(),
            'postForm'=>$postForm->createView(),
        ]);
    }


    /**
     * @Route("/post", name="createPost", methods="POST")
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function createPost(Request $request)
    {

        $post = new Post();
        $postForm = $this->createForm(PostType::class, $post);

        $postForm->handleRequest($request);
        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $post = $postForm->getData();
            $post->setAddTime(new \DateTime());
            $em=$this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }
        return $this->redirectToRoute('post');
    }

    /**
     * @Route("/post/{id}", name="deletePost")
     * @param PostRepository $postRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
