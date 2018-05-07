<?php

namespace MyApp\FreelancerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison")
 * @ORM\Entity(repositoryClass="MyApp\FreelancerBundle\Repository\LivraisonRepository")
 */
class Livraison
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
     * @ORM\Column(name="piece_jointe", type="string", length=255)
     */
    private $pieceJointe;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     *
     * @ORM\ManyToOne(targetEntity="MyApp\FreelancerBundle\Entity\User",inversedBy="livredbys")
     * @ORM\JoinColumn(name="livredby",referencedColumnName="id",onDelete="CASCADE")
     */
    private $livredby;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MyApp\FreelancerBundle\Entity\User",inversedBy="livredtos")
     * @ORM\JoinColumn(name="livredto",referencedColumnName="id",onDelete="CASCADE")
     */
    private $livredto;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MyApp\JobOwnerBundle\Entity\Project",inversedBy="livraisons")
     * @ORM\JoinColumn(name="project",referencedColumnName="id",onDelete="CASCADE")
     */
    private $project;

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
     * Set pieceJointe
     *
     * @param string $pieceJointe
     *
     * @return Livraison
     */
    public function setPieceJointe($pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;
    
        return $this;
    }

    /**
     * Get pieceJointe
     *
     * @return string
     */
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }

    /**
     * @return mixed
     */
    public function getLivredBy()
    {
        return $this->livredby;
    }

    /**
     * @param mixed $livredby
     */
    public function setLivredBy($livredby)
    {
        $this->livredby = $livredby;
    }

    /**
     * @return mixed
     */
    public function getLivredTo()
    {
        return $this->livredto;
    }

    /**
     * @param mixed $livredto
     */
    public function setLivredTo($livredto)
    {
        $this->livredto = $livredto;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }
}

