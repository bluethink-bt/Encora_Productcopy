<?php
/**
 * Encora Productcopy Module
 *
 * @category  Encora
 * @package   Encora_Productcopy
 */
namespace Encora\Productcopy\Api;

use Encora\Productcopy\Api\MessageInterface;

/**
 * Interface SubscriberInterface
 * @api
 */
interface SubscriberInterface
{
    /**
     * @return void
     */
    public function processMessage(MessageInterface $message);
}
