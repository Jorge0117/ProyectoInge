<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoundsFixture
 *
 */
class RoundsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'number' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'semester' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'year' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'start_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'end_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'approve_limit_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['semester', 'number', 'year'], 'length' => []],
            'approve_limit_date_UNIQUE' => ['type' => 'unique', 'columns' => ['approve_limit_date'], 'length' => []],
            'start_date_UNIQUE' => ['type' => 'unique', 'columns' => ['start_date'], 'length' => []],
            'end_date_UNIQUE' => ['type' => 'unique', 'columns' => ['end_date'], 'length' => []],
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
                'number' => 1,
                'semester' => 1,
                'year' => 1,
                'start_date' => '2018-10-03 14:55:58',
                'end_date' => '2018-10-03 14:55:58',
                'approve_limit_date' => '2018-10-03 14:55:58'
            ],
        ];
        parent::init();
    }
}
