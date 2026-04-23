<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public const LANDING_TEMPLATES = [
        'classic' => 'Классический',
        'editorial' => 'Премиальный журнал',
        'neon' => 'Яркий неон',
    ];

    public function landingTemplate(): string
    {
        $template = $this->landing_template ?? 'classic';

        return array_key_exists($template, self::LANDING_TEMPLATES) ? $template : 'classic';
    }

    public function landingTemplateName(): string
    {
        return self::LANDING_TEMPLATES[$this->landingTemplate()];
    }
}
