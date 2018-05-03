<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Friend
 *
 * @ORM\Table(name="friend")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\FriendRepository")
 */
class Friend
{
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
     *
     * @ORM\Column(name="idUser1", type="string", length=255)
     */
    private $idUser1;

    /**
     * @var string
     *
     * @ORM\Column(name="idUser2", type="string", length=255)
     */
    private $idUser2;


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
     * Set idUser1
     *
     * @param string $idUser1
     *
     * @return Friend
     */
    public function setIdUser1($idUser1)
    {
        $this->idUser1 = $idUser1;

        return $this;
    }

    /**
     * Get idUser1
     *
     * @return string
     */
    public function getIdUser1()
    {
        return $this->idUser1;
    }

    /**
     * Set idUser2
     *
     * @param string $idUser2
     *
     * @return Friend
     */
    public function setIdUser2($idUser2)
    {
        $this->idUser2 = $idUser2;

        return $this;
    }

    /**
     * Get idUser2
     *
     * @return string
     */
    public function getIdUser2()
    {
        return $this->idUser2;
    }
}

