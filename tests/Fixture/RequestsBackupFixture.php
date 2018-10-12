<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RequestsBackupFixture
 *
 */
class RequestsBackupFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'requests_backup';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'student_id' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'course_id' => ['type' => 'string', 'fixed' => true, 'length' => 7, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'class_id' => ['type' => 'string', 'fixed' => true, 'length' => 7, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'requests_backupcol' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'another_student_hours' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'another_assistant_hours' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'first_time' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'has_another_hours' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['student_id'], 'length' => []],
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
                'student_id' => 'e213805f-f239-46c3-87e1-11251e333e24',
                'course_id' => 'Lorem',
                'class_id' => 'Lorem',
                'requests_backupcol' => 'Lorem ipsum dolor sit amet',
                'another_student_hours' => 1,
                'another_assistant_hours' => 1,
                'first_time' => 1,
                'has_another_hours' => 1
            ],
        ];
        parent::init();
    }
}
