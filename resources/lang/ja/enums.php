<?php

use App\Enums\RecipeStatus;

return [
    RecipeStatus::class=> [
        RecipeStatus::RECIPE => 'レシピ',
        RecipeStatus::INGREDIENT => '材料',
        RecipeStatus::COOKING => '作り方',
        RecipeStatus::OPEN => '公開中',
        RecipeStatus::EMPTY => '未入力あり',
        RecipeStatus::CLOSE => '非公開',
    ],
];