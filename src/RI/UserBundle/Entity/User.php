<?php

namespace RI\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User {
     /**
     * @ORM\Id
     * @ORM\Column(name = "usr_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}

?>
