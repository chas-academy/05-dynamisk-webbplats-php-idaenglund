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

    public function createPost() {
        $postModel = new PostModel();

        if ($this->request->isPost()) {
            $title = $this->request->getParams()->get('title');
            $content = $this->request->getParams()->get('content');
            $categorie_id = $this->request->getParams()->get('categorie_id');
            $tags = $this->request->getParams()->get('tags');

            $postModel->create($title, $content, $categorie_id, $tags);
        }

        $userModel = new UserModel();
        $user = $userModel->readUser($this->userId);
        $posts = $postModel->getAll();
        $tags = $postModel->getTags();

        $properties = [
            'user' => $user,
            'posts' => $posts,
            'tags' => $tags
        ];

        return $this->render('views/createpost.php', $properties);
    }

    public function updatePost(int $postId)
    {
        $title = $this->request->getParams()->get('title');
        $content = $this->request->getParams()->get('content');
        $categorie_id =$this->request->getParams()->get('categorie_id');
        $tags = $this->request->getParams()->get('tags');

        $postModel = new PostModel();
   
        $isUpdated = $postModel->update($postId, $title, $content, $categorie_id, $tags);

        if ($isUpdated) {
            return $this->redirect('/');
        } else {
            throw new \Exception('AAAAAAAAAH!');
        }
       
   }

    public function deletePost(int $postId): string {

        $postModel = new PostModel();

        $post = $postModel->delete($postId);

        $properties = [
            'post' => $post
        ];
        return $this->redirect('/');
    }

    public function editPost(int $postId): string
     {
        $postModel = new PostModel(); 
        
        $post = $postModel->edit($postId);
        $tags = $postModel->getTags();
        $categories = $postModel->getCategories();

        $properties = [
            'post' => $post,
            'tags' => $tags,
            'categories' => $categories
        ];

        return $this->render('views/edittext.php', $properties);
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

    public function searchCategories(int $categorie_id): string
    {

        $postModel = new PostModel();

        $posts = $postModel->searchCategory($categorie_id);

        $properties = [
            'posts' => $posts,
            'categorie_id' => $categorie_id
        ];

        return $this->render('views/categories.php', $properties);
    }

}