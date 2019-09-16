<?php

namespace App\Domains\Users\Models\Traits;

use Illuminate\Support\Carbon;

trait UserAccessor
{
    public function getHtmlIsEnabledAttribute(): string
    {
        if ($this->is_enabled)
            return '<span class="badge badge-success">Ativo</span>';

        return '<span class="badge badge-danger">Inativo</span>';
    }

    // public function getLastLoginAtAttribute($value)
    // {
    //     if (is_array($value) && array_key_exists('date', $value)) {
    //         $value = $value['date'];
    //     }

    //     if (empty($value)) {
    //         return NULL;
    //     }

    //     return Carbon::parse($value)->format('d/m/Y H:i');
    // }
}
