<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NutritionMenusTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NutritionMenusTable Test Case
 */
class NutritionMenusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NutritionMenusTable
     */
    protected $NutritionMenus;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.NutritionMenus',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('NutritionMenus') ? [] : ['className' => NutritionMenusTable::class];
        $this->NutritionMenus = $this->getTableLocator()->get('NutritionMenus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->NutritionMenus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\NutritionMenusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
