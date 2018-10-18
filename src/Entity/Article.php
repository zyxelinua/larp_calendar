<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article extends News
{
    const NEWS_TYPE = 'article';

    const CATEGORY_ARTICLE="статья";
    const CATEGORY_OVERVIEW="обзор";
    const CATEGORY_ANNOUNCEMENT="объявление";

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="articles")
     * @Assert\NotBlank()
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Choice({Article::CATEGORY_ARTICLE, Article::CATEGORY_OVERVIEW, Article::CATEGORY_ANNOUNCEMENT})
     */
    private $category;

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }
}
