<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Topic;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CommentController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    
    
    #[Route('/addcomment', name: 'app_addcomment')]
    public function add(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $repositor = $this->getDoctrine()->getManager();
        $topic_id = $request->get('topic_id');
        $topic = $repositor->find(Topic::class, $topic_id);

        $manager = $this->getDoctrine(Comment::class)->getManager();
        $comment = new Comment;
        $comment->setText($request->get('comment_text'));
        $comment->setCommentator($this->getUser());
        $comment->setArticle($topic);
        $comment->setCreated(new \DateTime('now'));

        $manager->persist($comment);
        $manager->flush();

        return $this->redirectToRoute('app_topic', ['id' => $topic_id]);
    }
}
