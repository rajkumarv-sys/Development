<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Tsi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sr_tsi_subrd_cluster_150';

    /**
     * @var array
     */
    protected $guarded = []; // It make all columns can be fillable

}