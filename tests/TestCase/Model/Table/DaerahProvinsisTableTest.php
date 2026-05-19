<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DaerahProvinsisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DaerahProvinsisTable Test Case
 */
class DaerahProvinsisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DaerahProvinsisTable
     */
    protected $DaerahProvinsis;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DaerahProvinsis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DaerahProvinsis') ? [] : ['className' => DaerahProvinsisTable::class];
        $this->DaerahProvinsis = $this->getTableLocator()->get('DaerahProvinsis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DaerahProvinsis);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DaerahProvinsisTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getLists method
     *
     * @return void
     * @uses \App\Model\Table\DaerahProvinsisTable::getLists()
     */
    public function testGetLists(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
