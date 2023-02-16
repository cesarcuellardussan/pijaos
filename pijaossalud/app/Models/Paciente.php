<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pacientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_documento',
        'no_documento',
        'nombres',
        'apellidos',
        'fec_nacimiento',
        'email'
    ];


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
     * Get all of the GestionHospitalarias for the Paciente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gestionHospitalarias()
    {
        return $this->hasMany(GestionHospitalaria::class, 'no_doc_paciente', 'no_documento');
                    // ->join('pacientes', 'gestion_hospitalaria.tipo_doc_paciente', '=', 'pacientes.tipo_documento');
    }
}
