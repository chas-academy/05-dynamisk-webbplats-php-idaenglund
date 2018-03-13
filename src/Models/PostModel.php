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
        $query = 'SELECT p.id, p.title, p.content, p.postdate, u.username as author, c.name as category, c.id as category_id,
        GROUP_CONCAT(IFNULL(t.name, "")) as tags,
        GROUP_CONCAT(IFNULL(c.name, "")) as categories
        FROM posts p
        LEFT JOIN post_tags pt ON p.id = pt.post_id
        LEFT JOIN tags t ON t.id = pt.tag_id
        LEFT JOIN categories c on c.id = p.category_id
        LEFT JOIN users u on u.id = p.author_id
        WHERE p.id = :id';

        $sth = $this->db->prepare($query);
        $sth->bindValue(':id', $postId);
        $sth->execute();

        $posts = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        if (empty($posts)) {
            throw new NotFoundException();
        }

        return $posts[0];
    }

    public function getAll(): array
    {
        $query = 'SELECT p.id, p.title,  SUBSTRING(p.content, 1, 50) as content, p.postdate, u.username as author, c.name as category, c.id as category_id,
        GROUP_CONCAT(IFNULL(t.name, "")) as tags,
        GROUP_CONCAT(IFNULL(t.id, "")) as tag_ids,
        GROUP_CONCAT(IFNULL(c.name, "")) as categories
        FROM posts p
        LEFT JOIN post_tags pt ON p.id = pt.post_id
        LEFT JOIN tags t ON t.id = pt.tag_id
        LEFT JOIN categories c on c.id = p.category_id
        LEFT JOIN users u on u.id = p.author_id
        GROUP BY p.id
        ORDER BY postdate DESC';

        $sth = $this->db->prepare($query);
        $sth->execute();
        $response = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        
        return $response;
    }

    public function getCategories(): array
    {
        $query = 'SELECT * from categories';
        $sth = $this->db->prepare($query);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function search(string $searchQuery): array
    {
        $query = 'SELECT p.id, p.title, p.content, p.postdate, c.name as category, u.username as author,
        GROUP_CONCAT(IFNULL(t.name, "")) as tags
        FROM posts p
        LEFT JOIN post_tags pt ON p.id = pt.post_id
        LEFT JOIN tags t ON t.id = pt.tag_id
        LEFT JOIN users u on u.id = p.author_id
        LEFT JOIN categories c on c.id = p.category_id
        WHERE
        p.title LIKE :searchQuery
        OR
        p.content LIKE :searchQuery
        OR
        t.name LIKE :searchQuery
        GROUP BY p.id';


        $sth = $this->db->prepare($query);
        $sth->bindValue(':searchQuery', "%$searchQuery%");
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }


    public function create(string $title, string $content, int $category_id, int $author_id, array $tags = [])
    {
        $sql = 'INSERT INTO posts (title, postdate, content, category_id, author_id) VALUES (:title, NOW(), :content, :category_id, :author_id)';

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':author_id', $author_id);

        if (!$statement->execute()) {
            throw new Exception($statement->errorInfo()[2]);
        }

        $lastpost = $this->db->lastInsertId();

        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                $query = 'INSERT INTO post_tags(post_id, tag_id) VALUES (:post_id, :tag_id)';
                $statement = $this->db->prepare($query);

                $statement->bindValue(':post_id', $lastpost);
                $statement->bindValue(':tag_id', (int) $tag);

                if (!$statement->execute()) {
                    throw new Exception($statement->errorInfo()[2]);
                }
            }
        }

        return true;
    }

    public function delete(int $postId)
    {
        $sql ='DELETE FROM posts WHERE id = :id';
        $sth = $this->db->prepare($sql);

        return $sth->execute(['id' => $postId]);
    }

    public function edit(int $postId)
    {
        $sql = 'SELECT p.id as id, p.title, p.content, p.postdate, c.id as category_id, c.name as category,
            GROUP_CONCAT(IFNULL(t.id, "")) as tag_ids,
            GROUP_CONCAT(IFNULL(t.name, "")) as tag_names
            FROM posts p
            LEFT JOIN post_tags pt ON p.id = pt.post_id
            LEFT JOIN tags t ON t.id = pt.tag_id
            LEFT JOIN categories c on c.id = p.category_id WHERE p.id = :id';

        $sth = $this->db->prepare($sql);

        if (!$sth->execute(['id' => $postId])) {
            throw new Exception($sth->errorInfo()[2]);
        }

        $post = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME)[0];

        return $post;
    }

    public function update(int $postId, string $title, string $content, int $category_id, array $tags)
    {
        $sql = 'UPDATE posts SET title = :title, content = :content, postdate = NOW(), category_id = :category_id WHERE id = :post_id';

        $sth = $this->db->prepare($sql);

        $sth->bindValue(':title', $title);
        $sth->bindValue(':content', $content);
        $sth->bindValue(':post_id', $postId);
        $sth->bindValue(':category_id', $category_id);

        $sth->execute();

        // Kolla om denna tag redan finns för detta inlägg i post_tags (för att förhindra duplicering)
        $query = 'SELECT * FROM post_tags WHERE post_id = :post_id';

        // Nytt prepared statement
        $sth = $this->db->prepare($query);
        $sth->bindValue(':post_id', $postId);
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        // Räknare för att gå igenom alla resultaten från hämtningen tidigare
        $i = 0;

        // Loopa igenom tags arrayen
        foreach ($tags as $tag) {
            // Om vi hittar taggen så fortsätter vi bara
            if (isset($result[$i]['tag_id']) && $result[$i]['tag_id'] === $tag) {
                $query = 'DELETE FROM post_tags WHERE post_id = :post_id AND tag_id = :tag_id';
                $sth = $this->db->prepare($query);
                $sth->bindValue(':post_id', $postId);
                $sth->bindValue(':tag_id', $tag);

                if (!$sth->execute()) {
                    throw new Exception($sth->errorInfo()[2]);
                }
            }

            if ($tag === 'NULL') {
                $query = 'DELETE FROM post_tags WHERE post_id = :post_id';
                $sth = $this->db->prepare($query);
                $sth->bindValue(':post_id', $postId);

                if (!$sth->execute()) {
                    throw new Exception($sth->errorInfo()[2]);
                }
            } elseif (isset($result[$i]['tag_id']) && $result[$i]['tag_id'] !== $tag) {
                $query = 'UPDATE post_tags SET tag_id = :tag_id WHERE post_id = :post_id LIMIT 1';
                $sth = $this->db->prepare($query);
                $sth->bindValue(':tag_id', $tag);
                $sth->bindValue(':post_id', $postId);

                if (!$sth->execute()) {
                    throw new Exception($sth->errorInfo()[2]);
                }
            } else {
                $query = 'INSERT IGNORE INTO post_tags (post_id, tag_id) VALUES (:post_id, :tag_id)';
                $sth = $this->db->prepare($query);
                $sth->bindValue(':post_id', $postId);
                $sth->bindValue(':tag_id', $tag);

                if (!$sth->execute()) {
                    throw new Exception($sth->errorInfo()[2]);
                }
            }

            $i++;
        }

        return $postId;
    }

    public function searchCategory(int $category_id)
    {
        $sql = 'SELECT p.id, p.title, p.postdate, SUBSTRING(p.content, 1, 50) as content, c.name AS category, c.id AS category_id, u.username AS author,
        GROUP_CONCAT(IFNULL(t.name, "")) as tags,
        GROUP_CONCAT(t.id, "") as tag_ids
        FROM posts p
        RIGHT JOIN categories c ON p.category_id = c.id
        RIGHT JOIN users u ON p.author_id = u.id
        RIGHT JOIN post_tags pt ON p.id = pt.post_id
        RIGHT JOIN tags t ON t.id = pt.tag_id
        WHERE category_id = :category_id
        GROUP BY c.id';

        $sth = $this->db->prepare($sql);
        $sth->bindValue(':category_id', $category_id);

        $sth->execute();

        $posts = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        return $posts;
    }

    /**
     * Tags
     *
     */
    public function getTags(): array
    {
        $query = 'SELECT * from tags';

        $sth = $this->db->prepare($query);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function getTag(int $tag_id)
    {
        $query = 'SELECT * from tags WHERE id = :tag_id';

        $sth = $this->db->prepare($query);
        $sth->bindValue(':tag_id', $tag_id);
        $sth->execute();

        $post = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $post[0];
    }

    public function createTag(string $tag_name)
    {
        $query = 'INSERT INTO tags (name) VALUES (:tag_name)';
        $sth = $this->db->prepare($query);
        $sth->bindValue(':tag_name', $tag_name);

        return $sth->execute();
        ;
    }

    public function updateTag(int $tag_id, string $tag_name)
    {
        $query = 'UPDATE tags SET name = :tag_name WHERE id = :tag_id';

        $sth = $this->db->prepare($query);
        $sth->bindValue(':tag_id', $tag_id);
        $sth->bindValue(':tag_name', $tag_name);

        return $sth->execute();
    }

    public function deleteTag(int $tag_id)
    {
        $query = 'DELETE FROM tags WHERE id = :tag_id';

        $sth = $this->db->prepare($query);
        $sth->bindValue(':tag_id', $tag_id);
        return $sth->execute();
    }
}
