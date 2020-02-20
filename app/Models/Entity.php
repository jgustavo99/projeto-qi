<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'city_id', 'document', 'document_type', 'corporate_name', 'name', 'image', 'phone', 'address', 'neighborhood', 'cep', 'description_payment'
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
            if ($this->document_type == 1) {
                return mask($value, '###.###.###-##');
            } else {
                return mask($value, '##.###.###/####-##');
            }
        }

        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
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
