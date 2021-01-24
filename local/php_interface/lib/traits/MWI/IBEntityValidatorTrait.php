<?php


namespace MWI;

use \InvalidArgumentException as InvalidArgumentException;

/**
 * Trait IBEntityValidatorTrait
 * @package MWI
 */
trait IBEntityValidatorTrait
{
    /**
     * @param int $id
     * @return bool Return true if $id is valid, otherwise return false
     */
    private function isValidId($id)
    {
        if (intval($id)) {
            return true;
        } else {
            throw new InvalidArgumentException('Invalid ID.');
        }
    }
}