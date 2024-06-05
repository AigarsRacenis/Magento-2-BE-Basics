<?php
namespace Magebit\Faq\Model;

use Magebit\Faq\Api\QuestionManagementInterface;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResource;
use Magebit\Faq\Model\QuestionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

class QuestionManagement implements QuestionManagementInterface
{
    /**
     * @var QuestionResource
     */
    protected $questionResource;

    /**
     * @var QuestionFactory
     */
    protected $questionFactory;

    /**
     * QuestionManagement constructor.
     *
     * @param QuestionResource $questionResource
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        QuestionResource $questionResource,
        QuestionFactory $questionFactory
    ) {
        $this->questionResource = $questionResource;
        $this->questionFactory = $questionFactory;
    }

    /**
     * @inheritDoc
     */
    public function enableQuestion($questionId)
    {
        try {
            $question = $this->questionFactory->create();
            $this->questionResource->load($question, $questionId);
            if (!$question->getId()) {
                throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $questionId));
            }

            $question->setStatus(1); // Assuming 1 is the status code for "enabled"
            $this->questionResource->save($question);
            return true;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not enable question: %1', $e->getMessage()));
        }
    }

    /**
     * @inheritDoc
     */
    public function disableQuestion($questionId)
    {
        try {
            $question = $this->questionFactory->create();
            $this->questionResource->load($question, $questionId);
            if (!$question->getId()) {
                throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $questionId));
            }

            $question->setStatus(0); // Assuming 0 is the status code for "disabled"
            $this->questionResource->save($question);
            return true;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not disable question: %1', $e->getMessage()));
        }
    }
}
