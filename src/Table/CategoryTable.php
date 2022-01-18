<?php

namespace App\Table;

use App\Model\Category;
use \PDO;

class CategoryTable extends AbstractTable
{
    protected $table = 'category';
    protected $class = Category::class;

    /**
     * @param App\Model\Post[] $posts
     */
    public function hydratePosts (array $posts): void
    {
        $postById = [];
        foreach ($posts as $post) {
            $post->setCategories([]);
            $postById[$post->getID()] = $post;
        }
        $categories = $this->pdo
            ->query('SELECT c.*, pc.post_id
                            FROM post_category pc
                            JOIN category c ON c.id = pc.category_id
                            WHERE pc.post_id IN (' . implode(',', array_keys($postById)) . ')'
        )->fetchAll(PDO::FETCH_CLASS, $this->class);

        foreach ($categories as $category) {
            $postById[$category->getPostID()]->addCategory($category);
        }
    }

    public function all (): array
    {
        return $this->queryAndFetchAll("SELECT * FROM {$this->table} ORDER BY id DESC");
    }

    public function list (): array
    {
        $categories = $this->queryAndFetchAll("SELECT * FROM {$this->table} ORDER BY name ASC");
        $results = [];
        foreach ($categories as $category) {
            $results[$category->getID()] = $category->getName();
        }
        return $results;
    }

}