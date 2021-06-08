<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @Route("/", name="default")
     * @Route("/search/{searchterm}", name="search"), defaults={"searchterm":""})
     */
    public function index(Request $request, PostRepository $postRepo): Response
    {
        $items = [];
        if ($request->query->has('search')) {
            $search = $request->query->get('search');
            $items = $postRepo->search($search);
        } else {
            $items = $postRepo->findAll();
        }
        return $this->render('home/index.html.twig', [
            'items' => $items,
            'previous_search' => $search ?? ''
        ]);
    }
}
