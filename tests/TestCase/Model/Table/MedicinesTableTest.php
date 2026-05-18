<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicinesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicinesTable Test Case
 */
class MedicinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicinesTable
     */
    protected $Medicines;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Medicines',
        'app.Branches',
        'app.MedicineMerks',
        'app.MedicineGroups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Medicines') ? [] : ['className' => MedicinesTable::class];
        $this->Medicines = $this->getTableLocator()->get('Medicines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Medicines);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MedicinesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MedicinesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
