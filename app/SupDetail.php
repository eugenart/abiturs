<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupDetail extends Model
{
    protected $fillable = ['year_of_company',
        'notif_bach', 'notif_bach_f', 'notif_bach_f_en',
        'notif_master', 'notif_master_f', 'notif_master_f_en',
        'notif_asp', 'notif_asp_f', 'notif_asp_f_en',
        'notif_spo'];
}
