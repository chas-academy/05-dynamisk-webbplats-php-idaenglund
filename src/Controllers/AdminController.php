<?php

namespace Blogg\Controllers;

use Blogg\Exceptions\NotFoundException;

use Blogg\Models\PostModel;
use Blogg\Models\UserModel;

class AdminController extends AbstractController
{
    public function dashboard()
    {
        $postModel = new PostModel();

        $userModel = new UserModel();
        $user = $userModel->readUser($this->userId);
        $posts = $postModel->getAll();
        $tags = $postModel->getTags();
        $categories = $postModel->getCategories();

        $properties = [
            'user' => $user,
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories
        ];

        return $this->render('views/admin/dashboard.php', $properties);
    }

    public function createPost()
    {
        $postModel = new PostModel();
        $userModel = new UserModel();

        $user = $userModel->readUser($this->userId);
        $posts = $postModel->getAll();
        $tags = $postModel->getTags();
        $categories = $postModel->getCategories();

        if ($this->request->isPost()) {
            $title = $this->request->getParams()->get('title');
            $content = $this->request->getParams()->get('content');
            $category_id = $this->request->getParams()->get('category_id');
            $author_id = $this->request->getParams()->get('author_id');
            $tags = $this->request->getParams()->get('tags');

            if (isset($tags)) {
                $createdPostId = $postModel->create($title, $content, $category_id, $author_id, $tags);
            } else {
                $createdPostId = $postModel->create($title, $content, $category_id, $author_id, $tags = []);
            }

            if ($createdPostId) {
                return $this->redirect('/admin');
            } else {
                throw new \Exception('AAAAAAAAAH!');
            }
        }

        $properties = [
            'user' => $user,
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories
        ];

        return $this->render('views/admin/post/createpost.php', $properties);
    }

    public function updatePost(int $postId)
    {
        $title = $this->request->getParams()->get('title');
        $content = $this->request->getParams()->get('content');
        $category_id =$this->request->getParams()->get('category_id');
        $tags = $this->request->getParams()->get('tags');

        $postModel = new PostModel();

        $updatedPostId = $postModel->update($postId, $title, $content, $category_id, $tags);

        if ($updatedPostId) {
            return $this->redirect('/admin');
        } else {
            throw new \Exception('AAAAAAAAAH!');
        }
    }

    public function deletePost(int $postId): string
    {
        $postModel = new PostModel();

        $post = $postModel->delete($postId);

        $properties = [
            'post' => $post
        ];

        return $this->redirect('/admin');
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

        return $this->render('views/admin/post/editpost.php', $properties);
    }

    public function createTag()
    {
        if ($this->request->isPost()) {
            $tag_name = $this->request->getParams()->get('name');

            $postModel = new PostModel();

            $tagIsCreated = $postModel->createTag($tag_name);

            if ($tagIsCreated) {
                return $this->redirect('/admin');
            } else {
                throw new \Exception('AAAAAAAAAH!');
            }
        }

        return $this->render('views/admin/tag/createtag.php', []);
    }

    public function editTag(int $tag_id)
    {
        $postModel = new PostModel();

        $tag = $postModel->getTag($tag_id);

        $properties = [
            'tag' => $tag
        ];

        return $this->render('views/admin/tag/edittag.php', $properties);
    }

    public function updateTag(int $tag_id)
    {
        $name = $this->request->getParams()->get('name');
        $postModel = new PostModel();

        $updatedTagId = $postModel->updateTag($tag_id, $name);

        if ($updatedTagId) {
            $properties = ['successMessage' => 'Tag successfully updated :)!'];
            return $this->redirect('/admin', $properties);
        } else {
            throw new \Exception('AAAAAAAAAH!');
        }
    }

    public function deleteTag(int $tag_id)
    {
        $postModel = new PostModel();

        $deletedTagId = $postModel->deleteTag($tag_id);

        if ($deletedTagId) {
            return $this->redirect('/admin');
        } else {
            throw new \Exception('AAAAAAAAAH!');
        }
    }
}