<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserPayrollDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserPayrollDetailsTable Test Case
 */
class UserPayrollDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserPayrollDetailsTable
     */
    protected $UserPayrollDetails;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.UserPayrollDetails',
        'app.Users',
        'app.PayrollCodes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserPayrollDetails') ? [] : ['className' => UserPayrollDetailsTable::class];
        $this->UserPayrollDetails = $this->getTableLocator()->get('UserPayrollDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UserPayrollDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UserPayrollDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\UserPayrollDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
