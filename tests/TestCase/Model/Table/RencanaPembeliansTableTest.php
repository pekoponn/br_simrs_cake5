<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RencanaPembeliansTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RencanaPembeliansTable Test Case
 */
class RencanaPembeliansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RencanaPembeliansTable
     */
    protected $RencanaPembelians;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.RencanaPembelians',
        'app.Suppliers',
        'app.RencanaPembelianDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RencanaPembelians') ? [] : ['className' => RencanaPembeliansTable::class];
        $this->RencanaPembelians = $this->getTableLocator()->get('RencanaPembelians', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RencanaPembelians);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RencanaPembeliansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RencanaPembeliansTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
