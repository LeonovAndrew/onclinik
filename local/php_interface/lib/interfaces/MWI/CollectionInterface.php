<?php

namespace MWI;

/**
 * Interface CollectionInterface
 * @package MWI
 */
interface CollectionInterface
{
    /**
     * @description Add item to collection.
     *
     * @param $item
     * @return bool Return true if item was correctly added to collection, otherwise return false.
     */
    public function add($item);

    /**
     * @description Remove item from collection.
     *
     * @param int $id
     * @return bool Return true if item was successfully removed from collection, otherwise return false.
     */
    public function remove($id);

    /**
     * @description Update item in collection.
     *
     * @param object $item
     * @return bool Return true if item is in collection and was successfully updated, otherwise return false.
     */
    public function update($item);

    /**
     * @param $item
     * @return bool Return true if item have the right type for this collection, otherwise return false.
     * @throws InvalidArgumentException if the provided argument got the wrong type.
     */
    public function isCorrectType($item);

    /**
     * @param $item
     * @return bool Return true if item is in collection, otherwise return false.
     */
    public function contains($item);

    /**
     * @return array Return all items in collection
     */
    public function getList();

    /**
     * @return int Return number of items in collection.
     */
    public function size();

    /**
     * @return bool Return true if collection is empty, otherwise return false.
     */
    public function isEmpty();
}