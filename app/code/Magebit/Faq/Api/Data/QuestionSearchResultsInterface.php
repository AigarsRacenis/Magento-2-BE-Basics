<?php

namespace Magebit\Faq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;
use Magebit\Faq\Api\Data\QuestionInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return QuestionInterface[]
     */
    public function getItems();

    /**
     * Set questions list.
     *
     * @param QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
