<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Topic;
use App\Entity\Forum;
use App\Entity\SubForum;
use App\Repository\UserRepository;
use App\Repository\ForumRepository;
use App\Repository\SubForumRepository;
use App\Repository\CommentRepository;
use App\Repository\TopicRepository;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $admin = $this->getUser();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin
        ]);
    }

    #[Route('/admin/users', name: 'app_admin-users')]
    public function userList(): Response
    {
        $admin = $this->getUser();
        $users =  $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'users'=> $users
        ]);
    }

    #[Route('/delete_user/{id}', name: 'app_user_delete')]
    public function delete_user($id): Response
    {
        $manager = $this->getDoctrine(User::class)->getManager();
        $del_user = $manager->find(User::class, $id);
        $manager->remove($del_user);
        $manager->flush();
        return $this->redirectToRoute('app_admin-users');
    }


    #[Route('/admin/forums', name: 'app_admin-forums')]
    public function forumList(): Response
    {
        $admin = $this->getUser();
        $forums =  $this->getDoctrine()->getRepository(Forum::class)->findAll();

        return $this->render('admin/forums.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'forums'=> $forums
        ]);
    }


    #[Route('/admin/add_forum', name: 'app_admin_add_forum')]
    public function addForum(): Response
    {
        $admin = $this->getUser();
        $forums =  $this->getDoctrine()->getRepository(Forum::class)->findAll();

        return $this->render('admin/addforum.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'forums'=> $forums
        ]);
    }

    #[Route('/admin/save_forum', name: 'app_admin_save_forum')]
    public function saveForum(Request $request): Response
    {
        $admin = $this->getUser();
        $repositor = $this->getDoctrine(Forum::class)->getManager();

        $n_forum = new Forum;
        $n_forum->setKeywords($request->get('new_forum'));
        $n_forum->setCreatedAt(new \DateTime('now'));

        $repositor->persist($n_forum);
        $repositor->flush();

        return $this->redirectToRoute('app_admin-forums');
    }

    #[Route('/admin/edit_forum/{id}', name: 'app_admin_edit_forum')]
    public function editForum(Request $request, $id): Response
    {
        $admin = $this->getUser();
        $forum =  $this->getDoctrine()->getRepository(Forum::class)->find($id);

        return $this->render('admin/edit_forum.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'forum'=> $forum
        ]);
    }

    #[Route('/admin/save_forum/{id}', name: 'app_admin_s_forum')]
    public function save_Forum(Request $request, $id): Response
    {
        $admin = $this->getUser();
        $manager = $this->getDoctrine(Forum::class)->getManager();
        $edit_forum = $manager->find(Forum::class, $id);

        $edit_forum->setKeywords($request->get('edit_forum'));
        $edit_forum->setCreatedAt(new \DateTime('now'));

        $manager->flush();

        return $this->redirectToRoute('app_admin-forums');
    }



    #[Route('/admin/subforums', name: 'app_admin_subforums')]
    public function subforumList(): Response
    {
        $admin = $this->getUser();
        $subforums =  $this->getDoctrine()->getRepository(SubForum::class)->findAll();

        return $this->render('admin/subforums.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'subforums'=> $subforums
        ]);
    }

    #[Route('/admin/add_subforum', name: 'app_admin_add_subforum')]
      public function addSubForum(): Response
    {
        $admin = $this->getUser();
        $forums =  $this->getDoctrine()->getRepository(Forum::class)->findAll();

        return $this->render('admin/addsubforum.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'forums'=> $forums
        ]);
    }

    #[Route('/admin/edit_subforum/{id}', name: 'app_admin_edit_subforum')]
    public function editSubForum(Request $request, $id): Response
    {
        $admin = $this->getUser();
        $forums =  $this->getDoctrine()->getRepository(Forum::class)->findAll();
        $s_forum =  $this->getDoctrine()->getRepository(SubForum::class)->find($id);

        return $this->render('admin/edit_subforum.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            's_forum'=> $s_forum,
            'forums'=> $forums
        ]);
    }

    #[Route('/admin/save_subforum/{id}', name: 'admin_save_subforum')]
    public function save2SubForum(Request $request, $id): Response
    {
        $admin = $this->getUser();
        $manager = $this->getDoctrine(SubForum::class)->getManager();
        $edit_subforum = $manager->find(SubForum::class, $id);
        $forum = $this->getDoctrine()->getRepository(Forum::class)->find($request->get('edit_parent'));

        $edit_subforum->setParentId($forum);
        $edit_subforum->setSubforum($request->get('edit_subforum'));

        $manager->flush();

        return $this->redirectToRoute('app_admin_subforums');
       
    }



    #[Route('/admin/save_subforum', name: 'app_admin_save_subforum')]
    public function saveSubForum(Request $request): Response
    {
        $admin = $this->getUser();
        $repositor = $this->getDoctrine(Forum::class)->getManager();
        $forum = $this->getDoctrine()->getRepository(Forum::class)->find($request->get('parent'));

        $n_sforum = new SubForum;
        $n_sforum->setParentId($forum);
        $n_sforum->setSubforum($request->get('new_subforum'));

        $repositor->persist($n_sforum);
        $repositor->flush();

        return $this->redirectToRoute('app_admin_subforums');
    }



    #[Route('/admin/topics', name: 'app_admin_topics')]
    public function topicList(): Response
    {
        $admin = $this->getUser();
        $topics =  $this->getDoctrine()->getRepository(Topic::class)->findAll();

        return $this->render('admin/topics.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'topics'=> $topics
        ]);
    }

    #[Route('/admin/add_topic', name: 'app_admin_add_topic')]
      public function addTopic(): Response
    {
        $admin = $this->getUser();
        $sforums =  $this->getDoctrine()->getRepository(SubForum::class)->findAll();

        return $this->render('admin/addtopic.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'sforums'=> $sforums
        ]);
    }

    #[Route('/admin/edit_topic/{id}', name: 'app_admin_edit_topic')]
      public function editTopic($id): Response
    {
        $admin = $this->getUser();
        $sforums =  $this->getDoctrine()->getRepository(SubForum::class)->findAll();
        $edit_top =  $this->getDoctrine()->getRepository(Topic::class)->find($id);

        return $this->render('admin/edit_topic.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'sforums'=> $sforums,
            'edit_top'=> $edit_top
        ]);
    }

    #[Route('/admin/s_topic/{id}', name: 'app_admin_s_topic')]
      public function storeTopic($id, Request $request): Response
    {
        $admin = $this->getUser();
        $repositor = $this->getDoctrine(Topic::class)->getManager();
        $subforum = $this->getDoctrine()->getRepository(SubForum::class)->find($request->get('edit_parent_ctg'));
        $edit_top =  $this->getDoctrine()->getRepository(Topic::class)->find($id);
        
        $edit_top->setSubforumId($subforum);
        $edit_top->setTitle($request->get('edit_topic_title'));
        $edit_top->setText($request->get('edit_topic_text'));
        $edit_top->setUpdatedAt(new \DateTime('now'));

        $repositor->flush();

        return $this->redirectToRoute('app_admin_topics');
    }

    #[Route('/admin/save_topic', name: 'app_admin_save_topic')]
    public function saveTopic(Request $request): Response
    {
        $admin = $this->getUser();
        $repositor = $this->getDoctrine(Forum::class)->getManager();
        $subforum = $this->getDoctrine()->getRepository(SubForum::class)->find($request->get('parent_ctg'));

        $n_topic = new Topic;
        $n_topic->setSubforumId($subforum);
        $n_topic->setTitle($request->get('new_topic_title'));
        $n_topic->setText($request->get('new_topic_text'));
        $n_topic->setCreatedAt(new \DateTimeImmutable);
        $n_topic->setUpdatedAt(new \DateTime('now'));
        $n_topic->setAutor($this->getUser());
        $n_topic->setAutorName($this->getUser());

        $repositor->persist($n_topic);
        $repositor->flush();

        return $this->redirectToRoute('app_admin_topics');
    }

    #[Route('/delete_topic/{id}', name: 'app_admin_delete_topic')]
    public function delete_topic($id): Response
    {
        $manager = $this->getDoctrine(Topic::class)->getManager();
        $edit_topic = $manager->find(Topic::class, $id);
        $manager->remove($edit_topic);
        $manager->flush();
        return $this->redirectToRoute('app_admin_topics');
    }




    #[Route('/admin/comments', name: 'app_admin_comments')]
    public function commentList(): Response
    {
        $admin = $this->getUser();
        $comments =  $this->getDoctrine()->getRepository(Comment::class)->findAll();

        return $this->render('admin/comments.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'comments'=> $comments
        ]);
    }

    #[Route('/admin/save_comment/{id}', name: 'app_admin_save_comment')]
    public function saveComment($id, Request $request): Response
    {
        $admin = $this->getUser();
        $repositor = $this->getDoctrine(Comment::class)->getManager();
        $edit_com =  $this->getDoctrine()->getRepository(Comment::class)->find($id);

        $edit_com->setText($request->get('edit_comment_text'));
        $repositor->flush();

        return $this->redirectToRoute('app_admin_comments');
    }

    #[Route('/admin/edit_comment/{id}', name: 'app_admin_edit_comment')]
    public function editComment($id): Response
    {
        $admin = $this->getUser();
        $comment =  $this->getDoctrine()->getRepository(Comment::class)->find($id);

        return $this->render('admin/edit_comment.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin,
            'comment'=> $comment
        ]);
    }
    
    #[Route('/delete_com/{id}', name: 'app_admin_delete_com')]
    public function delete_comment($id): Response
    {
        $manager = $this->getDoctrine(Comment::class)->getManager();
        $del_com = $manager->find(Comment::class, $id);
        $manager->remove($del_com);
        $manager->flush();
        return $this->redirectToRoute('app_admin_comments');
    }

}
