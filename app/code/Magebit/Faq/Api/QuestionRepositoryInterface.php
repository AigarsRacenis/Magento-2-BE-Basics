<?php

namespace Magebit\Faq\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface QuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param \Magebit\Faq\Api\Data\QuestionInterface $question
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Magebit\Faq\Api\Data\QuestionInterface $question);

    /**
     * Retrieve question.
     *
     * @param int $questionId
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($questionId);

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magebit\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question.
     *
     * @param \Magebit\Faq\Api\Data\QuestionInterface $question
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Magebit\Faq\Api\Data\QuestionInterface $question);

    /**
     * Delete question by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($questionId);
}
