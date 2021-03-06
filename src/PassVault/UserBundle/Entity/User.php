<?php

namespace PassVault\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity()
 * @ORM\Table(name="pv_users")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(),
     * @Assert\Length(min=2),
     * @Assert\Length(max=50),
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Firstname does not contain numbers"
     * )
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(),
     * @Assert\Length(min=2),
     * @Assert\Length(max=50),
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Lastname does not contain numbers"
     * )
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(targetEntity="\PassVault\PassBundle\Entity\Node", mappedBy="owner", cascade={"all"})
     **/
    private $nodes;

    /**
     * @ORM\OneToMany(targetEntity="TeamUser", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     **/
    private $assocTeams;

    /**
     * @ORM\OneToMany(targetEntity="\PassVault\PassBundle\Entity\NodeUser", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     **/
    private $assocNodes;


    public function __construct()
    {
        parent::__construct();
        $this->teamUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getFullName()
    {
        return $this->getFirstname().' '.$this->lastname;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata
            ->addPropertyConstraint('password', new Assert\Length(array(
                'min' => 8,
                'minMessage' => 'Your password must contain at least 8 characters'
            )))
            ->addPropertyConstraint('plainPassword', new Assert\Length(array(
                'min' => 8,
                'minMessage' => 'Your password must contain at least 8 characters'
            )))
        ;
    }

    /**
     * @param $email
     */
    public function setEmail($email){
        parent::setEmail($email);
        $this->setUsername($email);
    }



    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * Add node
     *
     * @param \PassVault\PassBundle\Entity\Node $node
     *
     * @return User
     */
    public function addNode(\PassVault\PassBundle\Entity\Node $node)
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * Remove node
     *
     * @param \PassVault\PassBundle\Entity\Node $node
     */
    public function removeNode(\PassVault\PassBundle\Entity\Node $node)
    {
        $this->nodes->removeElement($node);
    }

    /**
     * Get nodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Add assocTeam
     *
     * @param \PassVault\UserBundle\Entity\TeamUser $assocTeam
     *
     * @return User
     */
    public function addAssocTeam(\PassVault\UserBundle\Entity\TeamUser $assocTeam)
    {
        $this->assocTeams[] = $assocTeam;

        return $this;
    }

    /**
     * Remove assocTeam
     *
     * @param \PassVault\UserBundle\Entity\TeamUser $assocTeam
     */
    public function removeAssocTeam(\PassVault\UserBundle\Entity\TeamUser $assocTeam)
    {
        $this->assocTeams->removeElement($assocTeam);
    }

    /**
     * Get assocTeams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssocTeams()
    {
        return $this->assocTeams;
    }

    /**
     * Add assocNode
     *
     * @param \PassVault\PassBundle\Entity\NodeUser $assocNode
     *
     * @return User
     */
    public function addAsscNode(\PassVault\PassBundle\Entity\NodeUser $assocNode)
    {
        $this->assocNodes[] = $assocNode;

        return $this;
    }

    /**
     * Remove assocNode
     *
     * @param \PassVault\PassBundle\Entity\NodeUser $assocNode
     */
    public function removeAssocNode(\PassVault\PassBundle\Entity\NodeUser $assocNode)
    {
        $this->assocNodes->removeElement($assocNode);
    }

    /**
     * Get asscNodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssocNodes()
    {
        return $this->assocNodes;
    }
}
