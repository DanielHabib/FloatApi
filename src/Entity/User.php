<?php

namespace FloatApi\Entity;

use FloatApi\Behavior;


/**
 * @Entity(repositoryClass="FloatApi\Repository\UserRepository")
 * @HasLifecycleCallbacks
 * @Table(name="users")
 **/
class User
{
    use Behavior\Entity\Date\HasCreatedDate;
    use Behavior\Entity\Date\HasUpdatedDate;
    use Behavior\Entity\HasId;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $email;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $password;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
