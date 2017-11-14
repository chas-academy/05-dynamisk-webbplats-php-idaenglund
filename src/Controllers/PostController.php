<?php

namespace Blogg\Controllers;

use Blogg\Exceptions\DbException;
use Blogg\Exceptions\NotFoundException;
use Blogg\Models\PostModel;
use Blogg\Models\UserModel;

class PostController extends AbstractController
{
    const PAGE_LENGTH = 10;

    public function getAllWithPage($page): string
    {
        $page = (int)$page;
        $postModel = new PostModel();

        $posts = $postModel->getAll($page, self::PAGE_LENGTH);
        
        $properties = [
            'posts' => $posts,
            'currentPage' => $page,
            'lastPage' => count($posts) < self::PAGE_LENGTH
        ];
        return $this->render('views/posts.php', $properties);
    }

    public function getAll(): string
    {
        return $this->getAllWithPage(1);
    }

    public function get(int $postId): string
    {
        $postModel = new PostModel();

        try {
            $post = $postModel->get($postId);
        } catch (\Exception $e) {
            $properties = ['errorMessage' => 'Post not found!'];
            return $this->render('views/error.php', $properties);
        }

        $properties = ['post' => $post];
        return $this->render('views/post.php', $properties);
    }

    public function createPost() {
        $userModel = new UserModel();
        $postModel = new PostModel();
        $user = $userModel->readUser($this->userId);
        $posts = $postModel->getAll();

        $properties = [
            'user' => $user,
            'posts' => $posts
        ];

        return $this->render('views/createpost.php', $properties);
    }

    public function updatePost(int $postId)
    {
        $title = $this->request->getParams()->get('title');
        $content = $this->request->getParams()->get('content');

        $postModel = new PostModel();
   
        $isUpdated = $postModel->update($postId, $title, $content);

        if ($isUpdated) {
            return $this->redirect('/');
        } else {
            throw new \Exception('AAAAAAAAAH!');
        }
       
   }

    public function deletePost(int $postId) {
        $postId = $_POST['postId'];

        $postModel = new PostModel();

        $postModel->delete($postId);
            
        return $this->redirect('/');
    }

    public function editPost(int $postId): string
     {
        $postModel = new PostModel(); 
        
        $post = $postModel->edit($postId);

        $properties = [
            'post' => $post
        ];

        return $this->render('views/edittext.php', $properties);
    }
}