<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message = "article.news.not_blank")
     * @ORM\Column(name="news", type="string", length=255, unique=true)
     */
    private $news;

    /**
     * @Assert\NotBlank(message = "article.news.not_blank")
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @Assert\NotBlank(message = "article.news.not_blank")
     * @ORM\Column(name="short_description", type="text")
     */
    private $shortDescription;

    /**
     * @Assert\NotBlank(message = "article.news.not_blank")
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @Assert\NotBlank(message = "article.news.not_blank")
     * @ORM\Column(name="year", type="date")
     */
    private $year;

    /**
     * @Assert\Regex(pattern="/\d+/", message = "article.popular.regex")
     * @Assert\NotBlank(message = "category.name.not_blank")
     * @ORM\Column(name="popular", type="integer")
     */
    private $popular;

    /**
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="similarReturn")
     * @ORM\JoinTable(name="similar",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="relateded_article_id", referencedColumnName="id")}
     *      )
     */
    private $similar;

    /**
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="similar")
     */
    private $similarReturn;

    public function __construct()
    {
        $this->similar = new \Doctrine\Common\Collections\ArrayCollection();
        $this->similarReturn = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set news
     *
     * @param string $news
     *
     * @return Article
     */
    public function setNews($news)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return string
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Article
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set year
     *
     * @param \DateTime $year
     *
     * @return Article
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Article
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set popular
     *
     * @param integer $popular
     *
     * @return Article
     */
    public function setPopular($popular)
    {
        $this->popular = $popular;

        return $this;
    }

    /**
     * Get popular
     *
     * @return integer
     */
    public function getPopular()
    {
        return $this->popular;
    }


    public function setSimilar(\AppBundle\Entity\Article $similar)
    {
        $this->similar[] = $similar;

        return $this;
    }

    /**
     * Add similar
     *
     * @param \AppBundle\Entity\Article $similar
     *
     * @return Article
     */
    public function addSimilar(\AppBundle\Entity\Article $similar)
    {
        $this->similar[] = $similar;

        return $this;
    }

    /**
     * Remove similar
     *
     * @param \AppBundle\Entity\Article $similar
     */
    public function removeSimilar(\AppBundle\Entity\Article $similar)
    {
        $this->similar->removeElement($similar);
    }

    /**
     * Get similar
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSimilar()
    {
        return $this->similar;
    }

    /**
     * Add similarReturn
     *
     * @param \AppBundle\Entity\Article $similarReturn
     *
     * @return Article
     */
    public function addSimilarReturn(\AppBundle\Entity\Article $similarReturn)
    {
        $this->similarReturn[] = $similarReturn;

        return $this;
    }

    /**
     * Remove similarReturn
     *
     * @param \AppBundle\Entity\Article $similarReturn
     */
    public function removeSimilarReturn(\AppBundle\Entity\Article $similarReturn)
    {
        $this->similarReturn->removeElement($similarReturn);
    }

    /**
     * Get similarReturn
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSimilarReturn()
    {
        return $this->similarReturn;
    }
}
