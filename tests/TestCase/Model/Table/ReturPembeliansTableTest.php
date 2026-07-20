<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReturPembeliansTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReturPembeliansTable Test Case
 */
class ReturPembeliansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReturPembeliansTable
     */
    protected $ReturPembelians;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ReturPembelians',
        'app.Suppliers',
        'app.ReturPembelianDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ReturPembelians') ? [] : ['className' => ReturPembeliansTable::class];
        $this->ReturPembelians = $this->getTableLocator()->get('ReturPembelians', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ReturPembelians);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ReturPembeliansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ReturPembeliansTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
