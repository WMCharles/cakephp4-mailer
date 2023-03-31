<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayrollCodesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayrollCodesTable Test Case
 */
class PayrollCodesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayrollCodesTable
     */
    protected $PayrollCodes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PayrollCodes',
        'app.UserPayrollDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PayrollCodes') ? [] : ['className' => PayrollCodesTable::class];
        $this->PayrollCodes = $this->getTableLocator()->get('PayrollCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PayrollCodes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PayrollCodesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
