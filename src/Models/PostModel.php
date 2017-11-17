<?php

namespace Blogg\Models;

use Blogg\Domain\Post;
use Blogg\Exceptions\DbException;
use Blogg\Exceptions\NotFoundException;
use PDO;

class PostModel extends AbstractModel
{
    const CLASSNAME = '\Blogg\Domain\Post';

    public function get(int $postId): Post
    {
        $query = 'SELECT * FROM posts WHERE id = :id';
        $sth = $this->db->prepare($query);
        $sth->execute(['id' => $postId]);

        $posts = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        
        if (empty($posts)) {
            throw new NotFoundException();
        }

        return $posts[0];
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM posts';

        $sth = $this->db->prepare($query);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function search(string $searchQuery): array
    {
        $query = 'SELECT * FROM posts 
        WHERE 
        title LIKE :searchQuery 
        OR 
        content LIKE :searchQuery';

        $sth = $this->db->prepare($query);
        $sth->bindValue(':searchQuery', "%$searchQuery%");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function create(string $title, string $content, int $categorie_id, int $tag_id = null) 
    {
        $sql = 'INSERT INTO posts (title, postdate, content, categorie_id, tag_id) VALUES (:title, NOW(), :content, :categorie_id, :tag_id)';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content); 
        $statement->bindValue(':categorie_id', $categorie_id);
        $statement->bindValue(':tag_id', $tag_id); 

        $statement->execute();
    }

    public function delete(int $postId) 
    {
        $sql ='DELETE FROM posts WHERE id = :id';
        $sth = $this->db->prepare($sql);
        
        
        return $sth->execute(['id' => $postId]);
    }

    public function edit(int $postId) 
    {
        $sql = 'SELECT * FROM posts WHERE id = :id'; 
        
        $sth = $this->db->prepare($sql);
        $sth->execute(['id' => $postId]);

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME)[0];
    }

    public function update(int $postId, string $title, string $content, int $categorie_id) 
    {
        $sql = 'UPDATE posts SET title = :title, content = :content, postdate = NOW(), categorie_id = :categorie_id WHERE id = :id'; 
        
        $sth = $this->db->prepare($sql);

        $sth->bindValue(':title', $title);
        $sth->bindValue(':content', $content);
        $sth->bindValue(':id', $postId);
        $sth->bindValue(':categorie_id', $categorie_id);
        $sth->bindValue(':tag_id', $tag_id); 

        return $sth->execute();
    }

    public function searchCategory(int $categorie_id)
    {
        $sql = 'SELECT p.id, p.title, p.postdate, p.content, p.categorie_id, p.tag_id, c.name, c.id
        FROM posts p
        RIGHT JOIN categories c ON p.categorie_id = c.id
        WHERE categorie_id = :category_id'; 

        $sth = $this->db->prepare($sql);
        $sth->bindValue(':category_id', $categorie_id);

        $sth->execute();

        $posts = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        return $posts;
    }
}

