<?php

namespace Blogg\Controllers;

use Blogg\Exceptions\DbException;
use Blogg\Exceptions\NotFoundException;
use Blogg\Models\PostModel;

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
        $title = $_POST['title'];
        $content = $_POST['content'];

        $postModel = new PostModel();

        $post = $postModel->create($title, $content);

        return $this->redirect('/login');
    }

 

    public function deletePost() {
        $postId = $_POST['postId'];

        $postModel = new PostModel();

        $postModel->delete($postId);
            
        return $this->redirect('/login');
    }
}