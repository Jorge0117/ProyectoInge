<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RequestsRequirementsFixture
 *
 */
class RequestsRequirementsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'requirement_number' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'request_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'state' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => 'p', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'request_id' => ['type' => 'index', 'columns' => ['request_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['requirement_number', 'request_id'], 'length' => []],
            'requests_requirements_ibfk_1' => ['type' => 'foreign', 'columns' => ['request_id'], 'references' => ['requests', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'requests_requirements_ibfk_2' => ['type' => 'foreign', 'columns' => ['requirement_number'], 'references' => ['requirements', 'requirement_number'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'requirement_number' => 1,
                'request_id' => 1,
                'state' => 'Lorem ipsum dolor sit ame'
            ],
        ];
        parent::init();
    }
}
