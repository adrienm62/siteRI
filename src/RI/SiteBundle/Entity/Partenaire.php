<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\PartenaireRepository")
 */
class Partenaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="par_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="par_nom", type="string", length=255)
     */
    private $par_nom;

    /**
     * @var string
     *
     * @ORM\Column(name="par_pays", type="string", length=255)
     */
    private $par_pays;

    /**
     * @var string
     *
     * @ORM\Column(name="par_ville", type="string", length=255)
     */
    private $par_ville;

    /**
     * @var string
     *
     * @ORM\Column(name="par_adresse", type="string", length=255)
     */
    private $par_adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="par_coordonnees", type="string", length=255)
     */
    private $par_coordonnees;


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
     * Set par_nom
     *
     * @param string $parNom
     * @return Partenaire
     */
    public function setParNom($parNom)
    {
        $this->par_nom = $parNom;
    
        return $this;
    }

    /**
     * Get par_nom
     *
     * @return string 
     */
    public function getParNom()
    {
        return $this->par_nom;
    }

    /**
     * Set par_pays
     *
     * @param string $parPays
     * @return Partenaire
     */
    public function setParPays($parPays)
    {
        $this->par_pays = $parPays;
    
        return $this;
    }

    /**
     * Get par_pays
     *
     * @return string 
     */
    public function getParPays()
    {
        return $this->par_pays;
    }

    /**
     * Set par_ville
     *
     * @param string $parVille
     * @return Partenaire
     */
    public function setParVille($parVille)
    {
        $this->par_ville = $parVille;
    
        return $this;
    }

    /**
     * Get par_ville
     *
     * @return string 
     */
    public function getParVille()
    {
        return $this->par_ville;
    }

    /**
     * Set par_adresse
     *
     * @param string $parAdresse
     * @return Partenaire
     */
    public function setParAdresse($parAdresse)
    {
        $this->par_adresse = $parAdresse;
    
        return $this;
    }

    /**
     * Get par_adresse
     *
     * @return string 
     */
    public function getParAdresse()
    {
        return $this->par_adresse;
    }

    /**
     * Set par_coordonnees
     *
     * @param string $parCoordonnees
     * @return Partenaire
     */
    public function setParCoordonnees($parCoordonnees)
    {
        $this->par_coordonnees = $parCoordonnees;
    
        return $this;
    }

    /**
     * Get par_coordonnees
     *
     * @return string 
     */
    public function getParCoordonnees()
    {
        return $this->par_coordonnees;
    }
}
