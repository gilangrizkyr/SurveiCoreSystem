<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeBanner extends Widget
{
    protected static ?int $sort = -2; // Top of the page
    protected int|string|array $columnSpan = 'full';
    protected static string $view = 'filament.widgets.welcome-banner';
}