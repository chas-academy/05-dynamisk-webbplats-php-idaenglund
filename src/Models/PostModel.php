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

    public function search(int $tag_id): array
    {
        $query = <<<SQL
        SELECT * FROM posts LEFT JOIN tags On tag_id=tags_id
        WHERE $tags_id LIKE :searchstring 
SQL;
        $sth = $this->db->prepare($query);
        $sth->bindValue('title', "%$title%");
        $sth->bindValue('content', "%$content%");
        $sth->bindValue('tag_id', "%$tag_id");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function create(string $title, string $content, int $categorie_id, int $tag_id ) 
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

    public function searchCategorie(int $categorie_id)
    {
        $sql = 'SELECT * FROM posts LEFT JOIN categories ON categorie_id=categorie.Id WHERE categorie_id = :categorie_id'; 

        $sth = $this->db->prepare($sql);

        return $posts[0];
    }
}

