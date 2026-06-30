<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SST extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sst_data';

    /**
     * @var array
     */
    protected $guarded = []; // It make all columns can be fillable

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('channel_name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('sub_channel_name');
    }

}