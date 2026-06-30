<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HighwayOutlet;

class HighwayStructure extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'highway_structure';

    /**
     * @var array
     */
    protected $guarded = []; // It make all columns can be fillable

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function highwayOutlets()
    {
        return $this->hasMany(HighwayOutlet::class,'highway_id','ref_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('sub_channel_name');
    }

}
