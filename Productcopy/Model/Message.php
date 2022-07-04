<?php
/**
 * Support Encora Productcopy Module
 *
 * @category  Encora
 * @package   Encora_Productcopy
 */
namespace Encora\Productcopy\Model;

use Encora\Productcopy\Api\MessageInterface;

/**
 * Class Message
 * @package Encora\Productcopy\Model
 */
class Message
{
      /**
     * @var string
     */
    protected $message;

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        return $this->message = $message;
    }
}
