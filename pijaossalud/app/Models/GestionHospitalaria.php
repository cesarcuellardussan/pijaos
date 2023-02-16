<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionHospitalaria extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gestion_hospitalaria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_doc_paciente',
        'no_doc_paciente',
        'cod_hospital',
        'fec_ingreso',
        'fec_salida',
        'fec_creacion'
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
     * Get the paciente that owns the GestionHospitalaria
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'no_doc_paciente', 'no_documento');
                    // ->join('pacientes', 'gestion_hospitalaria.tipo_doc_paciente', '=', 'pacientes.tipo_documento');
    }

    /**
     * Get the hospital that owns the GestionHospitalaria
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'cod_hospital', 'cod_hospital');
    }
}
