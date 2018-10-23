<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RequestsFixture
 *
 */
class RequestsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'round_start' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reception_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'class_year' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'course_id' => ['type' => 'string', 'fixed' => true, 'length' => 7, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'class_semester' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'class_number' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'student_id' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'another_assistant_hours' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'another_student_hours' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'has_another_hours' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'first_time' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'average' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'wants_student_hours' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'wants_assistant_hours' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'ckcourseid' => ['type' => 'index', 'columns' => ['course_id'], 'length' => []],
            'ck_round_start' => ['type' => 'index', 'columns' => ['round_start'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'student_id' => ['type' => 'unique', 'columns' => ['student_id', 'course_id', 'class_year', 'class_semester', 'class_number'], 'length' => []],
            'ck_round_start' => ['type' => 'foreign', 'columns' => ['round_start'], 'references' => ['rounds', 'start_date'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'ckcourseid' => ['type' => 'foreign', 'columns' => ['course_id'], 'references' => ['courses', 'code'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'id' => 1,
                'round_start' => '2018-10-21',
                'reception_date' => '2018-10-21',
                'class_year' => 'Lorem ipsum dolor sit amet',
                'course_id' => 'Lorem',
                'class_semester' => 1,
                'class_number' => 1,
                'student_id' => 'Lorem ipsum dolor ',
                'status' => 'Lorem ipsum dolor sit ame',
                'another_assistant_hours' => 1,
                'another_student_hours' => 1,
                'has_another_hours' => 1,
                'first_time' => 1,
                'average' => 1.5,
                'wants_student_hours' => 1,
                'wants_assistant_hours' => 1
            ],
        ];
        parent::init();
    }
}
