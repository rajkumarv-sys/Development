<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HighwayStructure;

class SubRDOutlet extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subrd_outlet';

    /**
     * @var array
     */
    protected $guarded = []; // It make all columns can be fillable

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function highwayName()
    {
        return $this->belongsTo(HighwayStructure::class,'highway_id','refid');
    }

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