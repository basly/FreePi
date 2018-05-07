<?php

namespace MyApp\JobOwnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity(repositoryClass="MyApp\JobOwnerBundle\Repository\PaymentRepository")
 */
class Payment
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
     *
     * @ORM\ManyToOne(targetEntity="MyApp\JobOwnerBundle\Entity\Project",inversedBy="status")
     * @ORM\JoinColumn(name="status",referencedColumnName="id",onDelete="CASCADE")
     */
    private $status;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MyApp\FreelancerBundle\Entity\User",inversedBy="paidbys")
     * @ORM\JoinColumn(name="paidby",referencedColumnName="id",onDelete="CASCADE")
     */
    private $paidby;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MyApp\FreelancerBundle\Entity\User",inversedBy="paidtos")
     * @ORM\JoinColumn(name="paidto",referencedColumnName="id",onDelete="CASCADE")
     */
    private $paidto;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MyApp\JobOwnerBundle\Entity\Project",inversedBy="payments")
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
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getPaidBy()
    {
        return $this->paidby;
    }

    /**
     * @param mixed $paidby
     */
    public function setPaidBy($paidby)
    {
        $this->paidby = $paidby;
    }

    /**
     * @return mixed
     */
    public function getPaidTo()
    {
        return $this->paidto;
    }

    /**
     * @param mixed $paidto
     */
    public function setPaidTo($paidto)
    {
        $this->paidto = $paidto;
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

