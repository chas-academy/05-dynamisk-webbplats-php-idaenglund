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

        $properties = [
            'post' => $post
        ];

        return $this->render('views/post.php', $properties);
    }

    public function search(): string
    {

        if ($this->request->isPost()) {
            $postModel = new PostModel();

            $query = $this->request->getParams()->get('query');

            $posts = $postModel->search($query);

            $properties = [
                'posts' => $posts
            ];

            return $this->render('views/posts.php', $properties);
        }

    }

    public function searchCategories(int $category_id): string
    {

        $postModel = new PostModel();

        $posts = $postModel->searchCategory($category_id);

        $properties = [
            'posts' => $posts,
            'category_id' => $category_id
        ];

        return $this->render('views/categories.php', $properties);
    }

}