<?php

use App\Models\Category;
use App\Models\Transaction;

    it('calculates spent as sum of expense transactions', function (){
        $category = Category::factory()->create(['planned_amount' => 13000]);

        Transaction::factory()
            ->for($category)
            ->for($category->member)
            ->expense()
            ->create(['amount' => 5000]);

        expect($category->spent())->toBe(5000.0);
    });

    it('calculates remaining as planned_amount minus spent', function (){
        $category = Category::factory()->create(['planned_amount' => 13000]);

        Transaction::factory()->for($category)->for($category->member)->expense()->create(['amount'=> 5000]);

        expect($category->remaining())->toBe(8000.0);
    });

    it('returns zero percentage complete when nothing is spent', function (){
        $category = Category::factory()->create(['planned_amount' => 13000]);

        expect($category->percentageComplete())->toBe(0.0);
    });

    it('ignores income transactions when calculating spent', function (){
        $category = Category::factory()->create(['planned_amount' => 13000]);

        Transaction::factory()->for($category)->for($category->member)->income()->create(['amount'=> 5000]);

        expect($category->spent())->toBe(0.0);
    });

