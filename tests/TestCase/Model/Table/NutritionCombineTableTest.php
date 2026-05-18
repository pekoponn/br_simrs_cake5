<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NutritionCombineTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NutritionCombineTable Test Case
 */
class NutritionCombineTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NutritionCombineTable
     */
    protected $NutritionCombine;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.NutritionCombine',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('NutritionCombine') ? [] : ['className' => NutritionCombineTable::class];
        $this->NutritionCombine = $this->getTableLocator()->get('NutritionCombine', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->NutritionCombine);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\NutritionCombineTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\NutritionCombineTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
