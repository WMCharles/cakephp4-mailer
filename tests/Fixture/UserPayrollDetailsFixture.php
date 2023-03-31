<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserPayrollDetailsFixture
 */
class UserPayrollDetailsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'payroll_code_id' => 1,
                'amount' => 1.5,
                'created' => '2023-03-31 14:27:13',
                'modified' => '2023-03-31 14:27:13',
            ],
        ];
        parent::init();
    }
}
