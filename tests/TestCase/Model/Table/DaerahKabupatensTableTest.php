<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DaerahKabupatensTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DaerahKabupatensTable Test Case
 */
class DaerahKabupatensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DaerahKabupatensTable
     */
    protected $DaerahKabupatens;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DaerahKabupatens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DaerahKabupatens') ? [] : ['className' => DaerahKabupatensTable::class];
        $this->DaerahKabupatens = $this->getTableLocator()->get('DaerahKabupatens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DaerahKabupatens);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DaerahKabupatensTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getList method
     *
     * @return void
     * @uses \App\Model\Table\DaerahKabupatensTable::getList()
     */
    public function testGetList(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
