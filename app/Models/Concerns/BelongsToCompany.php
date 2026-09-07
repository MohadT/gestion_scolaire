<?php

namespace App\Models\Concerns;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $companyId = session('company_id');

            if ($companyId) {
                $builder->where(
                    $builder->getModel()->getTable() . '.company_id',
                    $companyId
                );
            }
        });

        static::creating(function ($model) {
            if (!$model->company_id && session('company_id')) {
                $model->company_id = session('company_id');
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
