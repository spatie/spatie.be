<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function setUp(): void
    {
        $this->product = Product::factory()->create();
    }

}
