<?php

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\{
    Data\QuestionInterface,
    QuestionRepositoryInterface
};
use Magebit\Faq\Model\ResourceModel\{
    Question as QuestionResource,
    Question\CollectionFactory as QuestionCollectionFactory
};
use Magento\Framework\Api\{
    SearchCriteriaInterface,
    SearchCriteria\CollectionProcessorInterface,
    SearchResultsInterfaceFactory,

};
use Magento\Framework\Exception\{
    CouldNotDeleteException,
    CouldNotSaveException,
    NoSuchEntityException
};
use Psr\Log\LoggerInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var QuestionResource
     */
    protected $resource;

    /**
     * @var QuestionFactory
     */
    protected $questionFactory;

    /**
     * @var QuestionCollectionFactory
     */
    protected $questionCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param QuestionResource $resource
     * @param QuestionFactory $questionFactory
     * @param QuestionCollectionFactory $questionCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        QuestionResource $resource,
        QuestionFactory $questionFactory,
        QuestionCollectionFactory $questionCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->questionFactory = $questionFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function save(QuestionInterface $question)
    {
        try {
            $this->resource->save($question);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new CouldNotSaveException(__('Could not save the question.'));
        }
        return $question;
    }

    /**
     * @inheritdoc
     */
    public function getById($questionId)
    {
        $question = $this->questionFactory->create();
        $this->resource->load($question, $questionId);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $questionId));
        }
        return $question;
    }

    /**
     * @inheritdoc
     */
    public function delete(QuestionInterface $question)
    {
        try {
            $this->resource->delete($question);
            return true;
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new CouldNotDeleteException(__('Could not delete the question.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function deleteById($questionId)
    {
        return $this->delete($this->getById($questionId));
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->questionCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
