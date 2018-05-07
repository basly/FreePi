<?php

namespace MyApp\FreelancerBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
*/
class User extends BaseUser {

/**
 * @ORM\Id
 * @ORM\Column(type="integer")
 * @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="skills", type="string",length=255)
     */
    private $skills;
    /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string",length=255)
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string",length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string",length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="birthDate", type="string",length=255)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string",length=255)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string",length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="registrationNum", type="string",length=255)
     */
    private $registrationNum;

    /**
     * @var string
     *
     * @ORM\Column(name="disponibility", type="string",length=255)
     */
    private $disponibility;

    /**
     * @var string
     *
     * @ORM\Column(name="activitySector", type="string",length=255)
     */
    private $activitySector;

    /**
     * @var string
     *
     * @ORM\Column(name="socialRaison", type="string",length=255)
     */
    private $socialRaison;

    /**
     * @var string
     *
     * @ORM\Column(name="cv", type="string",length=255,nullable=true)
     */
    private $cv;


    /**
     * One Jobonwer has Many Projects.
     * @ORM\OneToMany(targetEntity="MyApp\JobOwnerBundle\Entity\Project", mappedBy="jobowner")
     */
    public $projects;

    /**
     * One Freelancer has Many Projects.
     * @ORM\OneToMany(targetEntity="MyApp\FreelancerBundle\Entity\Demande", mappedBy="freelancer")
     */
    public $affected;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\ForumBundle\Entity\Topic", mappedBy="user")
     */
    private $topics;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\ForumBundle\Entity\Post", mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\FreelancerBundle\Entity\Livraison", mappedBy="livredby")
     */
    private $livredbys;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\FreelancerBundle\Entity\Livraison", mappedBy="livredto")
     */
    private $livredtos;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\JobOwnerBundle\Entity\Payment", mappedBy="paidby")
     */
    private $paidbys;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\JobOwnerBundle\Entity\Payment", mappedBy="paidto")
     */
    private $paidtos;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->projects= new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->livredbys = new ArrayCollection();
        $this->livredtos = new ArrayCollection();
        $this->paidbys = new ArrayCollection();
        $this->paidtos = new ArrayCollection();
        $this->affected = new ArrayCollection();
}


    /**
     * @return string
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * @param string $domaine
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;
    }

    /**
     * @return string
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param string $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getDisponibility()
    {
        return $this->disponibility;
    }

    /**
     * @param string $disponibility
     */
    public function setDisponibility($disponibility)
    {
        $this->disponibility = $disponibility;
    }

    /**
     * @return string
     */
    public function getActivitySector()
    {
        return $this->activitySector;
    }

    /**
     * @param string $activitySector
     */
    public function setActivitySector($activitySector)
    {
        $this->activitySector = $activitySector;
    }

    /**
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param string $cv
     */
    public function setCv($cv)
    {
        $this->cv = $cv;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getRegistrationNum()
    {
        return $this->registrationNum;
    }

    /**
     * @param string $registrationNum
     */
    public function setRegistrationNum($registrationNum)
    {
        $this->registrationNum = $registrationNum;
    }

    /**
     * @return string
     */
    public function getSocialRaison()
    {
        return $this->socialRaison;
    }

    /**
     * @param string $socialRaison
     */
    public function setSocialRaison($socialRaison)
    {
        $this->socialRaison = $socialRaison;
    }

}