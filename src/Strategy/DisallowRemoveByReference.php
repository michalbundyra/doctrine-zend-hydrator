<?php

declare(strict_types=1);

namespace Doctrine\Zend\Hydrator\Strategy;

/**
 * When this strategy is used for Collections, if the new collection does not contain elements that are present in
 * the original collection, then this strategy will not remove those elements. At most, it will add new elements. For
 * instance, if the collection initially contains elements A and B, and that the new collection contains elements B
 * and C, then the final collection will contain elements A, B and C.
 * This strategy is by reference, this means it won't use the public API to remove elements
 */
class DisallowRemoveByReference extends AbstractCollectionStrategy
{
    /**
     * {@inheritDoc}
     */
    public function hydrate($value, ?array $data)
    {
        $collection = $this->getCollectionFromObjectByReference();
        $collectionArray = $collection->toArray();

        $toAdd = array_udiff($value, $collectionArray, [$this, 'compareObjects']);

        foreach ($toAdd as $element) {
            $collection->add($element);
        }

        return $collection;
    }
}
