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

    public function create(string $title, string $content, int $categorie_id, array $tags)
    {
        $sql = 'INSERT INTO posts (title, postdate, content, categorie_id) VALUES (:title, NOW(), :content, :categorie_id)';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':categorie_id', $categorie_id);


        $lastpost = $this->db->lastInsertId;
        
        // hämsta senaste ID på posten.
           
        // loopa över alla taggar och sätt in dem i tags. då får den tag name och tag id. (kolla papper.)

        foreach ($tags as $tag) {
            $query = 'INSERT INTO tags(name) VALUES (:tag)';

            $sth = $this->db->prepare($query);
            $sth->bindValue(":tag", $tag);
            $sth->execute();
        }

        $lasttagid;
        //loopa igenom alla taggar igen.
      // stoppa in idt på taggen ($tags) i din ledger table (som kopplar ihop tagg id med post id.)
        // OCH post id.
        // foreach($tags as $tag)
        // {
        //     $query = 'INSERT INTO posts_tags(post_id, tag_id) VALUES (:post_id, :tag_id)';
        //     $sth->bindValue('post_id', $lastpost);
        //     $sth->bindValue('tag_id', $tag_id);
        //     $sth->execute();
        // }
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

    public function update(int $postId, string $title, string $content, int $categorie_id, int $tag_id)
    {
        $sql = 'UPDATE posts SET title = :title, content = :content, postdate = NOW(), categorie_id = :categorie_id WHERE id = :id, tag_id = :tag_id Where id = :id';
        
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
