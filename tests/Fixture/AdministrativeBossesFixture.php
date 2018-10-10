<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AdministrativeBossesFixture
 *
 */
class AdministrativeBossesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'user_id' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['user_id'], 'length' => []],
            'administrative_bosses_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'identification_number'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'user_id' => '8727cde6-6c73-4a2c-b29e-b0c6308b6cdc'
            ],
        ];
        parent::init();
    }
}
