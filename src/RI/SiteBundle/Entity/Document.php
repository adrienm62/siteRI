<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    /**
     * Get doc_chemin
     *
     * @return string 
     */
    public function getDocChemin()
    {
        return $this->doc_chemin;
    }
}