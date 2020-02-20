<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'city_id', 'entity_id', 'name', 'password', 'email', 'document', 'phone', 'is_entity', 'deleted_at'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Atributo das colunas de data
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * Remove os caracteres do documento
     *
     * @param $value
     * @return int
     */
    public function setDocumentAttribute($value)
    {
        // Remove os caracteres
        $this->attributes['document'] = preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Adiciona máscara
     *
     * @param $value
     * @return string
     */
    public function getDocumentAttribute($value)
    {
        if (!empty($value)) {
            return mask($value, '###.###.###-##');
        }

        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donors()
    {
        return $this->hasMany(CampaignDonor::class);
    }

    /**
     * Retorna a cidade relacionada
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
