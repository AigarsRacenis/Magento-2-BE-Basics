<?php

namespace Magebit\Faq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return \Magebit\Faq\Api\Data\QuestionInterface[]
     */
    public function getItems();

    /**
     * Set questions list.
     *
     * @param \Magebit\Faq\Api\Data\QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
