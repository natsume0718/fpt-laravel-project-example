<?php


namespace App\Common\Users\Models;

use App\Base\Models\BaseModel;

/**
 * Class User
 * @package App\Common\Users\Models
 */
class User extends BaseModel
{
    private $name;

    private $email;

    private $password;

    private $remember_token;

    private $email_verified_at;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return string
     */
    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getRememberToken(): string
    {
        return $this->remember_token;
    }

    /**
     * @param string $remember_token
     * @return User
     */
    public function setRememberToken(string $remember_token): User
    {
        $this->remember_token = $remember_token;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmailVerifiedAt()
    {
        return $this->email_verified_at;
    }

    /**
     * @param $email_verified_at
     * @return User
     */
    public function setEmailVerifiedAt($email_verified_at): User
    {
        $this->email_verified_at = $email_verified_at;

        return $this;
    }
}
