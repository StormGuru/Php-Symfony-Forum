<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\SubForum;
use App\Repository\SubForumRepository;

class SubForumController extends AbstractController
{
    #[Route('/subforum/{id}', name: 'app_sub_forum')]
    public function show($id): Response
    {   
        $repository = $this->getDoctrine()->getManager();
        $subforum = $repository->find(SubForum::class, $id);
        return $this->render('sub_forum/index.html.twig', [
            'controller_name' => 'SubForumController',
            'subforum' => $subforum
        ]);
    }
}
