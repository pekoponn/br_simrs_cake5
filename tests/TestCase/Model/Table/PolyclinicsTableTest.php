<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PolyclinicsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PolyclinicsTable Test Case
 */
class PolyclinicsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PolyclinicsTable
     */
    protected $Polyclinics;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Polyclinics',
        'app.Doctors',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Polyclinics') ? [] : ['className' => PolyclinicsTable::class];
        $this->Polyclinics = $this->getTableLocator()->get('Polyclinics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Polyclinics);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PolyclinicsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
