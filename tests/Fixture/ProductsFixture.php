<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
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
                'description' => 'Lorem ipsum dolor sit amet',
                'price' => 1.5,
                'user_id' => 1,
                'category_id' => 1,
                'created' => '2023-03-28 06:58:47',
                'modified' => '2023-03-28 06:58:47',
            ],
        ];
        parent::init();
    }
}
