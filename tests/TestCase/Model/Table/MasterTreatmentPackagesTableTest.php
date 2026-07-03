<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterTreatmentPackagesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterTreatmentPackagesTable Test Case
 */
class MasterTreatmentPackagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterTreatmentPackagesTable
     */
    protected $MasterTreatmentPackages;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterTreatmentPackages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterTreatmentPackages') ? [] : ['className' => MasterTreatmentPackagesTable::class];
        $this->MasterTreatmentPackages = $this->getTableLocator()->get('MasterTreatmentPackages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterTreatmentPackages);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterTreatmentPackagesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
