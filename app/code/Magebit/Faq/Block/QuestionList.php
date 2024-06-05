<?php

declare(strict_types=1);

namespace Magebit\Faq\Block;

use Magebit\Faq\Model\ResourceModel\Question\{
    Collection,
    CollectionFactory
};
use Magento\Framework\View\Element\Template;
use Template\Context;

class QuestionList extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $questionCollectionFactory;

    /**
     * @param Context $context
     * @param CollectionFactory $questionCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $questionCollectionFactory,
        array $data = []
    ) {
        $this->questionCollectionFactory = $questionCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Gets the question collection
     *
     * @return Collection
     */
    public function getQuestions()
    {
        $questionCollection = $this->questionCollectionFactory->create();
        $questionCollection->addFieldToFilter('status', true);
        $questionCollection->setOrder('position', 'ASC');

        return $questionCollection;
    }
}
