<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PageTranslation
 *
 * @ORM\Table(name="page_translations")
 * @ORM\Entity
 */
class PageTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotNull
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * @var string
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * @var string
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $meta_title;

    /**
     * @return string
     */
    public function getMetaTitle() {
        return $this->meta_title;
    }

    public function setMetaTitle($meta_title) {
        $this->meta_title = $meta_title;

        return $this;
    }

    /**
     * @var string
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    private $meta_description;

    /**
     * @return string
     */
    public function getMetaDescription() {
        return $this->meta_description;
    }

    /**
     * @param $meta_description
     * @return $this
     */
    public function setMetaDescription($meta_description) {
        $this->meta_description = $meta_description;

        return $this;
    }

    /**
     * @var string
     * @ORM\Column(name="meta_keywords", type="string", length=255, nullable=true)
     */
    private $meta_keywords;

    /**
     * @return string
     */
    public function getMetaKeywords() {
        return $this->meta_keywords;
    }

    /**
     * @param $meta_keywords
     * @return $this
     */
    public function setMetaKeywords($meta_keywords) {
        $this->meta_keywords = $meta_keywords;

        return $this;
    }
}

