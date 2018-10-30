<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InfoRequestsFixture
 *
 */
class InfoRequestsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'fecha' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'carne' => ['type' => 'string', 'length' => 6, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'nombre' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'promedio' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'anno' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'semestre' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'curso' => ['type' => 'string', 'fixed' => true, 'length' => 7, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'grupo' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'ronda' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'estado' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'otras_horas' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'id_prof' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_options' => [
            'engine' => null,
            'collation' => null
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
                'fecha' => '2018-10-30',
                'carne' => 'Lore',
                'nombre' => 1,
                'promedio' => 1.5,
                'anno' => 'Lorem ipsum dolor sit amet',
                'semestre' => 1,
                'curso' => 'Lorem',
                'grupo' => 1,
                'ronda' => 'Lorem ipsum dolor sit amet',
                'estado' => 'Lorem ipsum dolor sit ame',
                'otras_horas' => 1,
                'id_prof' => 'Lorem ipsum dolor '
            ],
        ];
        parent::init();
    }
}
