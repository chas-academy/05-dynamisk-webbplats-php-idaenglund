<?php

namespace Blogg\Models;

use Blogg\Domain\Post;
use Blogg\Exceptions\NotFoundException;
use PDO;
use Exception;

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
        $query = 'SELECT p.id, p.title, p.content, p.postdate, c.name as category,
        GROUP_CONCAT(IFNULL(t.name, "")) as tags
        FROM posts p
        LEFT JOIN post_tags pt ON p.id = pt.post_id
        LEFT JOIN tags t ON t.id = pt.tag_id
        LEFT JOIN categories c on c.id = p.categorie_id
        GROUP BY p.categorie_id';

        $sth = $this->db->prepare($query);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function getCategories(): array
    {
        $query = 'SELECT * from categories';
        $sth = $this->db->prepare($query);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function getTags(): array
    {
        $query = 'SELECT * from tags';

        $sth = $this->db->prepare($query);
        $sth->execute();

        return $sth->fetchAll();
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

    public function create(string $title, string $content, int $categorie_id, array $tags)
    {
        $sql = 'INSERT INTO posts (title, postdate, content, categorie_id) VALUES (:title, NOW(), :content, :categorie_id)';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':categorie_id', $categorie_id);
        
        if (!$statement->execute()) {
            throw new Exception($statement->errorInfo()[2]);
        }

        $lastpost = $this->db->lastInsertId();

        
        
        // hämsta senaste ID på posten.
           
        // loopa över alla taggar och sätt in dem i tags. då får den tag name och tag id. (kolla papper.)

        //loopa igenom alla taggar igen.
        // stoppa in idt på taggen ($tags) i din ledger table (som kopplar ihop tagg id med post id.)
        // OCH post id.
        foreach ($tags as $tag) {
            $query = 'INSERT INTO posts_tags(post_id, tag_id) VALUES (:post_id, :tag_id)';
            $sth = $this->db->prepare($query);

            $sth->bindValue('post_id', $lastpost);
            $sth->bindValue('tag_id', (int) $tag);
            
            if (!$sth->execute()) {
                throw new Exception($sth->errorInfo()[2]);
            }
        }
    }

    public function delete(int $postId)
    {
        $sql ='DELETE FROM posts WHERE id = :id';
        $sth = $this->db->prepare($sql);
        
        
        return $sth->execute(['id' => $postId]);
    }

    public function edit(int $postId)
    {
        $sql = 'SELECT p.id as id, p.title, p.content, p.postdate, c.id as categorie_id, c.name as category,
            GROUP_CONCAT(IFNULL(t.id, "")) as tag_ids,
            GROUP_CONCAT(IFNULL(t.name, "")) as tag_names
            FROM posts p
            LEFT JOIN post_tags pt ON p.id = pt.post_id
            LEFT JOIN tags t ON t.id = pt.tag_id
            LEFT JOIN categories c on c.id = p.categorie_id WHERE p.id = :id';
        
        $sth = $this->db->prepare($sql);

        if (!$sth->execute(['id' => $postId])) {
            throw new Exception($sth->errorInfo()[2]);
        }
    
        $post = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME)[0];

        return $post;
    }

    public function update(int $postId, string $title, string $content, int $categorie_id, array $tags)
    {
        $sql = 'UPDATE posts SET title = :title, content = :content, postdate = NOW(), categorie_id = :categorie_id WHERE id = :id';
        
        $sth = $this->db->prepare($sql);

        $sth->bindValue(':title', $title);
        $sth->bindValue(':content', $content);
        $sth->bindValue(':id', $postId);
        $sth->bindValue(':categorie_id', $categorie_id);
        $sth->execute();

        $lastpost = $this->db->lastInsertId();

        foreach ($tags as $tag) {
            $query = 'UPDATE post_tags SET tag_id = :tag_id WHERE post_id = :post_id';
            $sth = $this->db->prepare($query);

            $sth->bindValue('post_id', $lastpost);
            $sth->bindValue('tag_id', (int) $tag);
            
            if (!$sth->execute()) {
                throw new Exception($sth->errorInfo()[2]);
            }
        }
    }

    public function searchCategory(int $categorie_id)
    {
        $sql = 'SELECT p.id, p.title, p.postdate, p.content, p.categorie_id, c.name, c.id
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
