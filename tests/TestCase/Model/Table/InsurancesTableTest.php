<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InsurancesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InsurancesTable Test Case
 */
class InsurancesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InsurancesTable
     */
    protected $Insurances;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Insurances',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Insurances') ? [] : ['className' => InsurancesTable::class];
        $this->Insurances = $this->getTableLocator()->get('Insurances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Insurances);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InsurancesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
