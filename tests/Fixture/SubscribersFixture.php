<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SubscribersFixture
 */
class SubscribersFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'user_id' => 1,
                'created' => '2023-03-28 06:58:31',
                'modified' => '2023-03-28 06:58:31',
            ],
        ];
        parent::init();
    }
}
