<?php

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\{
    Api\SearchCriteriaInterface,
    Exception\LocalizedException,
    Exception\NoSuchEntityException
};

interface QuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function save(QuestionInterface $question);

    /**
     * Retrieve question.
     *
     * @param int $questionId
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function getById($questionId);

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question.
     *
     * @param QuestionInterface $question
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(QuestionInterface $question);

    /**
     * Delete question by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($questionId);
}
