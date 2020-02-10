<?php

namespace App\Models2\Royex;

use Illuminate\Database\Eloquent\Model;

class CompanyAddressSetting extends Model
{
    protected $table = 'royex_company_address_settings';
    protected $primaryKey = 'company_address_setting_id';

    protected $fillable = [
        'company_address_setting_id', 'address'
    ];
}
