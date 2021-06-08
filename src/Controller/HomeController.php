<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $postRepo = $this->getDoctrine()->getRepository(Post::class);

        $items = $postRepo->findAll();
        return $this->render('home/index.html.twig', [
            'items' => $items,
        ]);
    }
}
