<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hospitales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cod_hospital', 'nombre'];

        /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at','deleted_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get all of the gestionHospitalarias for the Hospital
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gestionHospitalarias()
    {
        return $this->hasMany(GestionHospitalaria::class, 'cod_hospital', 'cod_hospital');
    }
}
