<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 23/03/2017
 * Time: 11:17
 */

require_once  'trait.mail.php';

class ContactUs{
    use CustomMailing;
    private $firstName;
    private $lastName;
    private $senderEmail;
    private $subject;
    private $emailMessage;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * @param mixed $senderEmail
     */
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getEmailMessage()
    {
        return $this->emailMessage;
    }

    /**
     * @param mixed $emailMessage
     */
    public function setEmailMessage($emailMessage)
    {
        $this->emailMessage = $emailMessage;
    }


}
