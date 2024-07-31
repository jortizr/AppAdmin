<?php

namespace App\Controller;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CommentType;
use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(PostRepository $postRepository): Response
    {
        return $this->render('page/home.html.twig', [
            'posts' => $postRepository->findLatest(),
        ]);
    }

    #[Route('/blog/{slug}', name: 'app_post')]
    public function post(#[MapEntity(mapping: ['slug' => 'slug'])] Post $post): Response
    {
        $form = $this->createForm(CommentType::class);

        return $this->render('page/post.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    #[Route('/nuevo-comentario/{slug}', name: 'app_comment_new')]
    public function comment(Request $request,
     #[MapEntity(mapping: ['slug' => 'slug'])]
     Post $post, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $comment->setUser($this->getUser());
        $comment->setPost($post);
        
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);//manejamos los datos
        

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_post', 
                    ['slug' => $post->getSlug()]);
        }
        dd($post);
        return $this->render('page/post.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
