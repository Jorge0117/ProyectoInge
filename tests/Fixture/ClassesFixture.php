<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ClassesFixture
 *
 */
class ClassesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'course_id' => ['type' => 'string', 'fixed' => true, 'length' => 7, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'class_number' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'semester' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'year' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'state' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'professor_id' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'professor_id' => ['type' => 'index', 'columns' => ['professor_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['course_id', 'class_number', 'semester', 'year'], 'length' => []],
            'classes_ibfk_1' => ['type' => 'foreign', 'columns' => ['course_id'], 'references' => ['courses', 'code'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'classes_ibfk_2' => ['type' => 'foreign', 'columns' => ['professor_id'], 'references' => ['professors', 'user_id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'course_id' => '709df5fa-3f41-4268-a7cd-9fbee0a73121',
                'class_number' => 1,
                'semester' => 1,
                'year' => '3cb62e27-6293-4e23-80e3-36bd544da2a8',
                'state' => 1,
                'professor_id' => 'Lorem ip'
            ],
        ];
        parent::init();
    }
}
