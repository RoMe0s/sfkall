<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use AdminBundle\Traits\Entity\TranslationMagicTrait as TMT;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Page
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("slug")
 */
class Page
{

    use ORMBehaviors\Translatable\Translatable;
    use TMT;

    /**
     * @Assert\Valid
     */
    protected $translations;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     *
     */
    private $parentId;

    /**
     * @var Page
     *
     * @ORM\OneToOne(targetEntity="Page")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @Assert\NotNull
     * @Assert\Type("string")
     *
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @Assert\Image()
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="view_count", type="integer")
     * @Assert\GreaterThan(-1)
     */
    private $viewCount = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     * @Assert\NotNull
     * @Assert\Type("bool")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255, nullable=true)
     * @Assert\NotNull
     * @Assert\Type("string")
     */
    private $template;

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
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Page
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Get parent object
     *
     * @return Page|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Page
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set viewCount
     *
     * @param integer $viewCount
     *
     * @return Page
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * Get viewCount
     *
     * @return int
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Page
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Page
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set template
     *
     * @param string $template
     *
     * @return Page
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }


    public function showAction() {

        return '/pages/' . $this->slug;

    }

    /**
     *  @ORM\PrePersist
     */
    public function doStuffOnPrePersist()
    {
        $this->createdAt = new \DateTime();
    }

}

