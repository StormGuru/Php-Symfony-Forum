<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Forum;
use App\Entity\SubForum;
use App\Repository\ForumRepository;
use App\Repository\SubForumRepository;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'app_forum')]
    public function index(): Response
    {
        $forums = $this->forumRepository->findAll();
    
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController', 'forums' => $forums
        ]);
    }
}
