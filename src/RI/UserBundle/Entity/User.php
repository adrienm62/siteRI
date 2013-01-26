<?php

namespace RI\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser {
     /**
     * @ORM\Id
     * @ORM\Column(name = "id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer 
     */
    
   /**
     * @ORM\ManyToMany(targetEntity="RI\SiteBundle\Entity\Document", cascade = {"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $documents;
    
    /**
     * @ORM\ManyToMany(targetEntity="RI\SiteBundle\Entity\Stage", cascade = {"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $stage;
    
    public function getId()
    {
        return $this->id;
      
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add documents
     *
     * @param \RI\SiteBundle\Entity\Document $documents
     * @return User
     */
    public function addDocument(\RI\SiteBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;
    
        return $this;
    }

    /**
     * Remove documents
     *
     * @param \RI\SiteBundle\Entity\Document $documents
     */
    public function removeDocument(\RI\SiteBundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }
}