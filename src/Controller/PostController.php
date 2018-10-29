<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
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
        $postForm=$this->createForm(PostType::class);
        return $this->render('post/index.html.twig', [
            'post' => $postRepository->findAll(),
            'postForm'->$postForm,
        ]);
    }


    public function createPost()
    {
        $post = new Post();
        $post->setPost('Write a blog post');
        $post->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
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
