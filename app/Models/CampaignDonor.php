<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignDonor extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id', 'user_id', 'amount', 'status', 'confirmed_at'
    ];

    /**
     * Atributo das colunas de data
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'confirmed_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
