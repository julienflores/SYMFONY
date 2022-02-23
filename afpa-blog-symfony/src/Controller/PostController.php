<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class PostController extends AbstractController
{
    #[Route('/', name: 'post.index')]
    public function index(PostRepository $postRepo): Response
    {

        $postList=$postRepo->findAll();

        
        return $this->render('post/index.html.twig', [
            'postList' => $postList
        ]);
    }
    #[Route('/posts/{id}/delete', name: 'post.delete')]
    public function delete(Request $request,PostRepository $postRepo,$id, Post $post, ManagerRegistry $doctrine){

        // 1 : Transmettre l'id dans twig   possiblité: /posts/{{post.id}}/delete
        // 2 : Récupérer le post en fonction de l'id
        //$id  = $request ->get('id');
        // 3 : delete with repository
        //$post = $postRepo ->findOneBy(['id'=> $id]);
        
        
        $em=$doctrine->getManager(); //em=entitymanager qui possede la méthode remove
        $em->remove($post);
        $em->flush();
       
        // 4 : redirect to route index
        return  $this->redirectToRoute('post.index');
    }
}
