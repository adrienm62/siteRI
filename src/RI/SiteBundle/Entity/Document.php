<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    
    
    private $fileToRemove;
    
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
     * Set doc_nom with form
     *
     * @return string 
     */
    public function setName($docNom)
    {
        $this->doc_nom = $docNom;
    
        return $this;
    }
    
    /**
     * Get doc_nom wih form
     *
     * @return string 
     */
    public function getName()
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
        return null === $this->doc_chemin ? null : $this->getUploadRootDir().'/'.$this->doc_chemin;
    }

    /**
     * Get web path: Path of information that leads to the directory where web documents are stored
     * 
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->doc_chemin ? null : $this->getUploadDir().'/'.$this->doc_chemin;
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
    
    
    public function upload()
    {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }

        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->path = $this->file->getClientOriginalName();

        
    }
    
    public function delete(){
        $this->filenameForRemove = $this->getDocChemin();
        if ($this->filenameForRemove) {
            unlink($this->filenameForRemove);
        }
        
    }
    
    public function recupNomFichier(){
        return $this->file->getClientOriginalName();
    }

    
    public function __toString() {
        return $this->doc_nom . " " . $this->doc_datedepot;
    }
}