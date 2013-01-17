<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactPrincipal
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\ContactPrincipalRepository")
 */
class ContactPrincipal
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
