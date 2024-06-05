<?php

namespace Magebit\Faq\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'faq_question_collection';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(Question::class, QuestionResource::class);
    }
}
