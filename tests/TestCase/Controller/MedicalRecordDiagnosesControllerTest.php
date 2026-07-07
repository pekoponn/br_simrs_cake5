<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\MedicalRecordDiagnosesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\MedicalRecordDiagnosesController Test Case
 *
 * @uses \App\Controller\MedicalRecordDiagnosesController
 */
class MedicalRecordDiagnosesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MedicalRecordDiagnoses',
        'app.MedicalRecords',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\MedicalRecordDiagnosesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\MedicalRecordDiagnosesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\MedicalRecordDiagnosesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\MedicalRecordDiagnosesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\MedicalRecordDiagnosesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
