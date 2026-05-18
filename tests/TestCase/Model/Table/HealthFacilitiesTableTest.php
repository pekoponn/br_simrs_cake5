<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HealthFacilitiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HealthFacilitiesTable Test Case
 */
class HealthFacilitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HealthFacilitiesTable
     */
    protected $HealthFacilities;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.HealthFacilities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('HealthFacilities') ? [] : ['className' => HealthFacilitiesTable::class];
        $this->HealthFacilities = $this->getTableLocator()->get('HealthFacilities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->HealthFacilities);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\HealthFacilitiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
