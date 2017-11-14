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

    public function search(string $title): array
    {
        $query = <<<SQL
        SELECT * FROM posts
        WHERE title LIKE :searchstring OR content LIKE :searchstring 
SQL;
        $sth = $this->db->prepare($query);
        $sth->bindValue('title', "%$title%");
        $sth->bindValue('content', "%$content%");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function create(string $title, string $content) {
        $sql = 'INSERT INTO posts (title, postdate, content) VALUES (:title, NOW(), :content)';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content); 

        $statement->execute();

    }

    public function delete(int $postId) {
        $sql ='DELETE FROM posts WHERE id = :id';
        $sth = $this->db->prepare($sql);
        
        
        return $sth->execute(['id' => $postId]);
    }
}
