<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CommentType;

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
    public function post(string $slug, PostRepository $postRepository): Response
    {
        $post = $postRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(CommentType::class);

        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }

        return $this->render('page/post.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
