<?php

namespace App\Enums;

enum Rarity {
    case COMMON = 'Common';
    case UNCOMMON = 'Uncommon';
    case RARE = 'Rare';
    case DOUBLE_RARE = 'Double Rare';
    case Ultra_RARE = 'Ultra Rare';
    case ILLUSTRATION_RARE = 'Illustration Rare';
    case SPECIAL_ILLUSTRATION_RARE = 'Special Illustration Rare';
    case HYPER_RARE => 'Hyper Rare';
}
