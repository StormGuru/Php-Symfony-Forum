<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Topic;
use App\Entity\Comment;
use App\Repository\TopicRepository;

class TopicController extends AbstractController
{
    #[Route('/topic/{id}', name: 'app_topic')]
    public function topic($id): Response
    {
        $topicRepository = $this->getDoctrine()->getManager();
        $topic = $topicRepository->find(Topic::class, $id);

        return $this->render('topic/index.html.twig', [
            'controller_name' => 'TopicController',
            'topic' => $topic
        ]);
    }

    #[Route('/edit_topic/{id}', name: 'app_topic_edit')]
    public function edit_topic($id): Response
    {
        $topicRepository = $this->getDoctrine()->getManager();
        $edit_topic = $topicRepository->find(Topic::class, $id);

        return $this->render('topic/edit.html.twig', [
            'controller_name' => 'TopicController',
            'edit_topic' => $edit_topic,
        ]);
    }

    #[Route('/save_topic/{id}', name: 'app_topic_save')]
    public function save_topic($id, Request $request): Response
    {
        $manager = $this->getDoctrine(Topic::class)->getManager();
        $edit_topic = $manager->find(Topic::class, $id);
        $subforum_id = $edit_topic->getSubforumId(); 

        $edit_topic->setSubforumId($subforum_id);
        $edit_topic->setTitle($request->get('topic_title'));
        $edit_topic->setText($request->get('topic_text'));
        $edit_topic->setUpdatedAt(new \DateTime('NOW'));
        $edit_topic->setAutor($this->getUser());
        $edit_topic->setAutorName($this->getUser());

        $manager->flush();

        return $this->redirectToRoute('app_profile');

        

        return $this->render('topic/edit.html.twig', [
            'controller_name' => 'TopicController',
            'edit_topic' => $edit_topic,
        ]);
    }

    #[Route('/delete_topic/{id}', name: 'app_topic_delete')]
    public function delete_topic($id): Response
    {
        $manager = $this->getDoctrine(Topic::class)->getManager();
        $edit_topic = $manager->find(Topic::class, $id);
        $manager->remove($edit_topic);
        $manager->flush();
        return $this->redirectToRoute('app_profile');
    }
}
