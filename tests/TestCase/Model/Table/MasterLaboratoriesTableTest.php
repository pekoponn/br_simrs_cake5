<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterLaboratoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterLaboratoriesTable Test Case
 */
class MasterLaboratoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterLaboratoriesTable
     */
    protected $MasterLaboratories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MasterLaboratories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterLaboratories') ? [] : ['className' => MasterLaboratoriesTable::class];
        $this->MasterLaboratories = $this->getTableLocator()->get('MasterLaboratories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MasterLaboratories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MasterLaboratoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
