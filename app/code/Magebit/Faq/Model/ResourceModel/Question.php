<?php

namespace Magebit\Faq\Model\ResourceModel;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'faq_question_collection';
    /**
     * Define main table and primary key
     */
    protected function _construct()
    {
        $this->_init(QuestionInterface::TABLE, QuestionInterface::ID);
    }
}
