<?php

namespace MWI;

use \InvalidArgumentException as InvalidArgumentException;

/**
 * Class AbstractCollection
 * @package MWI
 */
class AbstractCollection implements CollectionInterface
{
    /**
     * @var string $itemsClass - contains collection items class
     * @var array $arItems - contains collection items
     * @var int $size - contains collection size
     */
    private $itemsClass;
    protected $arItems;
    protected $size;

    /**
     * AbstractCollection constructor.
     * @param string $className - class name of collection items
     */
    public function __construct($className)
    {
        $this->itemsClass = $className;
        $this->arItems = array();
        $this->size = 0;
    }

    /**
     * @param object $item
     * @return bool
     */
    public function add($item)
    {
        if ($this->isCorrectType($item)) {
            if (!$this->contains($item->id)) {
                $this->arItems[$item->id] = $item;
                $this->size++;

                return true;
            }
        }

        return false;
    }

    /**
     * @param object $item
     * @return bool
     */
    public function update($item)
    {
        if ($this->isCorrectType($item)) {
            if ($this->contains($item->id)) {
                $this->arItems[$item->id] = $item;

                return true;
            }
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        if ($this->contains($id)) {
            unset($this->arItems[$id]);
            $this->size--;

            return true;
        }

        return false;
    }

    /**
     * @param object $item
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function isCorrectType($item) {
        if ($item instanceof $this->itemsClass) {
            return true;
        } else {
            throw new InvalidArgumentException('Item got the wrong type.');
        }
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->arItems;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function contains($id)
    {
        return isset($this->arItems[$id]);
    }

    /**
     * @return int
     */
    public function size()
    {
        return $this->size;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->size() == 0;
    }

    /**
     * @return array Id's of all collection items
     */
    public function getIds()
    {
        return array_keys($this->arItems);
    }

    /**
     * @param int $id
     * @return object|bool Return item with $id from collection or false if it's not exist.
     */
    public function getById($id)
    {
        return $this->arItems[$id] ? $this->arItems[$id] : false;
    }
}