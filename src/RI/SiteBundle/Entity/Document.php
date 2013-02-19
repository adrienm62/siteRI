<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\DocumentRepository")
 */
class Document
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_nom", type="string", length=255)
     */
    private $doc_nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="doc_datedepot", type="date")
     */
    private $doc_datedepot;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_chemin", type="text")
     */
    private $doc_chemin;

    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    /**
     * @ORM\ManyToOne(targetEntity="RI\UserBundle\Entity\User", cascade = {"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set doc_nom
     *
     * @param string $docNom
     * @return Document
     */
    public function setDocNom($docNom)
    {
        $this->doc_nom = $docNom;
    
        return $this;
    }

    /**
     * Get doc_nom
     *
     * @return string 
     */
    public function getDocNom()
    {
        return $this->doc_nom;
    }

    /**
     * Set doc_datedepot
     *
     * @param \DateTime $docDatedepot
     * @return Document
     */
    public function setDocDatedepot($docDatedepot)
    {
        $this->doc_datedepot = $docDatedepot;
    
        return $this;
    }

    /**
     * Get doc_datedepot
     *
     * @return \DateTime 
     */
    public function getDocDatedepot()
    {
        return $this->doc_datedepot;
    }

    /**
     * Set doc_chemin
     *
     * @param string $docChemin
     * @return Document
     */
    public function setDocChemin($docChemin)
    {
        $this->doc_chemin = $docChemin;
    
        return $this;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Get doc_chemin
     *
     * @return string 
     */
    public function getDocChemin()
    {
        return $this->doc_chemin;
    }
    
    
    /**
     * Get absolute path
     * 
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * Get web path: Path of information that leads to the directory where web documents are stored
     * 
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
     * 
     * @return string
     */
    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche 
     * le document/image dans la vue.
     * 
     * @return string
     */
    public function getUploadDir()
    { 
        return 'uploads/documents';
    }
    
    public function __toString() {
        return $this->doc_nom . " " . $this->doc_datedepot;
    }
}