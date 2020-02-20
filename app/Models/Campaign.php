<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Campaign extends Model
{
    use Sluggable;

    /**
     * @var array
     */
    protected $fillable = [
        'entity_id', 'title', 'description', 'amount_goal', 'close_at', 'status', 'image', 'slug'
    ];

    /**
     * Atributo das colunas de data
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'close_at'
    ];

    /**
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donors()
    {
        return $this->hasMany(CampaignDonor::class);
    }

    /**
     * @return mixed
     */
    public function total_donated()
    {
        return $this->donors()->where('status', 2)->sum('amount');
    }

    /**
     * @return float|int
     */
    public function goal_percentage()
    {
        $goal = $this->amount_goal;
        $total_donated = $this->total_donated();

        return ($total_donated * 100) / $goal;
    }
}
