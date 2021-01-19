<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RecipeStatus extends Enum
{
    # レシピ作成済み
    const RECIPE = 'recipe';
    #材料入力済み
    const INGREDIENT = 'ingredient';
    #作り方入力済み
    const COOKING = 'cooking';
    #公開中
    const OPEN = 'open';
    #未入力の項目あり
    const EMPTY ='empty';
    #非公開中
    const CLOSE = 'close';
}
