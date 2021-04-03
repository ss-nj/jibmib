<?php

use App\Http\Commerce\Models\Attribute;

return [
    'entities' => [
        // 'articles' => '\Article' for simple sorting (entityName => entityModel) or
        // 'posts' => ['entity' => '\Post', 'relation' => 'tags'] for many to many or many to many polymorphic relation sorting
        'category' => \App\Http\Commerce\Models\Category::class, //
        'place' => \App\Http\Commerce\Models\Place::class, //
        'banner' => \App\Http\Core\Models\Banner\Banner::class, //
        'slider' => \App\Http\Core\Models\Slider::class, //
        'attribute-value' => \App\Http\Commerce\Models\AttributeValue::class, //
        'menu' => \App\Http\Core\Models\Menu::class, //
    ],
];
