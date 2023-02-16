<?php

namespace App\Http\Controllers;

use App\Models\GestionHospitalaria;
use App\Models\Hospital;
use App\Models\Paciente;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GestionHospitalariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gestiones_hospitalarias = GestionHospitalaria::get();
            $data = array();
            foreach ($gestiones_hospitalarias as $key => $gestionHospitalaria) {
                $acciones = '<button class="btn btn-sm btn-warning shadow" onclick="editGestion(\''.$gestionHospitalaria->id_hospitalizacion.'\')"><i class="fas fa-edit"></i> Editar</button>
                            <button class="btn btn-sm btn-danger shadow" onclick="deleteGestion(\''.$gestionHospitalaria->id_hospitalizacion.'\')"><i class="fas fa-trash-alt"></i> Eliminar</button>';
                $data[] = [
                    'id_hospitalizacion' => $gestionHospitalaria->id_hospitalizacion,
                    'fec_creacion'       => $gestionHospitalaria->created_at->format('Y-m-d H:i:s'),
                    'tipo_doc_paciente'  => $gestionHospitalaria->tipo_doc_paciente,
                    'no_doc_paciente'    => $gestionHospitalaria->no_doc_paciente,
                    'cod_hospital'       => $gestionHospitalaria->cod_hospital,
                    'fec_ingreso'        => $gestionHospitalaria->fec_ingreso,
                    'fec_salida'         => $gestionHospitalaria->fec_salida,
                    'action'             => $acciones
                ];
            }
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
        return view('gestiones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $Paciente = Paciente::get();
            $Hospitlal = Hospital::get();
            return ['paciente' => $Paciente, 'hospital' => $Hospitlal];
        } catch (\Throwable $th) {
            return $this->errorResponse('Ocurrio un error al intentar crear el recurso. Detalle: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_doc_paciente' => 'required|max:15|exists:pacientes,no_documento',
            'cod_hospital'    => 'required|digits_between:1,12|exists:hospitales,cod_hospital',
            'fec_ingreso'     => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $reserva = GestionHospitalaria::whereBetween('fec_ingreso', [$request->fec_ingreso, $request->fec_salida])->first();
                    if ($reserva) {
                        $fail('Una gestión hospitalaria ya se encuentra en proceso para ese período de tiempo.');
                    }
                },
            ],
            'fec_salida'      => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $reserva = GestionHospitalaria::whereBetween('fec_salida', [$request->fec_ingreso, $request->fec_salida])->first();

                    if ($reserva) {
                        $fail('Una gestión hospitalaria ya se encuentra en proceso para ese período de tiempo.');
                    }
                },
            ],
        ],[
            'no_doc_paciente.required' => 'El campo Paciente es obligatorio',
            'no_doc_paciente.exists'   => 'No se encontró un registro de paciente que coincida con los datos proporcionados. Es posible que el paciente haya sido eliminado o modificado previamente.',
            'cod_hospital.required'    => 'El campo hospital es obligatorio',
            'cod_hospital.exists'      => 'No se encontró un registro de hospital que coincida con los datos proporcionados. Es posible que el hospital haya sido eliminado o modificado previamente.',
            'fec_ingreso.required'     => 'El campo Fecha ingreso es obligatorio',
            'fec_salida.required'      => 'El campo Fecha salida es obligatorio',
        ]);

        try {
            if ($validator->fails()) {
                return $this->successResponse([
                    'title' => 'Validacion!',
                    'text'  => $validator->errors()->first(),
                    'icon'  => 'warning'
                ], 200);
            }else{
                $tipo_doc_paciente = Paciente::where('no_documento', $request->no_doc_paciente)->value('tipo_documento');
                GestionHospitalaria::create([
                    'tipo_doc_paciente' => $tipo_doc_paciente,
                    'no_doc_paciente'   => $request->no_doc_paciente,
                    'cod_hospital'      => $request->cod_hospital,
                    'fec_ingreso'       => $request->fec_ingreso,
                    'fec_salida'        => $request->fec_salida,
                ]);
                return $this->successResponse([
                    'title' => 'Gestión creada!',
                    'text'  => 'Se ha creado con éxito la gestión hospitalaria',
                    'icon'  => 'success'
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->successResponse([
                'title' => 'Error!',
                'text'  => $th->getMessage(),
                'icon'  => 'error'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GestionHospitalaria  $gestionHospitalaria
     * @return \Illuminate\Http\Response
     */
    public function show(GestionHospitalaria $gestionHospitalaria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GestionHospitalaria  $gestionHospitalaria
     * @return \Illuminate\Http\Response
     */
    public function edit($id_hospitalizacion)
    {
        try {
            return [
                "gestion"    => GestionHospitalaria::where("id_hospitalizacion",$id_hospitalizacion)->first(),
                "pacientes"  => Paciente::get(),
                "hospitales" => Hospital::get()
            ];
        } catch (\Throwable $th) {
            return $this->errorResponse('Ocurrio un error al intentar crear el recurso. Detalle: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GestionHospitalaria  $gestionHospitalaria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_hospitalizacion)
    {
        $validator = Validator::make($request->all(), [
            'no_doc_paciente' => 'required|max:15|exists:pacientes,no_documento',
            'cod_hospital'    => 'required|digits_between:1,12|exists:hospitales,cod_hospital',
            'fec_ingreso'     => [
                'required',
                function ($attribute, $value, $fail) use ($request,$id_hospitalizacion) {
                    $reserva = GestionHospitalaria::whereBetween('fec_ingreso', [$request->fec_ingreso, $request->fec_salida])
                                ->where('id_hospitalizacion', '!=', $id_hospitalizacion)
                                ->first();
                    if ($reserva) {
                        $fail('Una gestión hospitalaria ya se encuentra en proceso para ese período de tiempo.');
                    }
                },
            ],
            'fec_salida'      => [
                'required',
                function ($attribute, $value, $fail) use ($request,$id_hospitalizacion) {
                    $reserva = GestionHospitalaria::whereBetween('fec_salida', [$request->fec_ingreso, $request->fec_salida])
                                ->where('id_hospitalizacion', '!=', $id_hospitalizacion)
                                ->first();

                    if ($reserva) {
                        $fail('Una gestión hospitalaria ya se encuentra en proceso para ese período de tiempo.');
                    }
                },
            ],
        ],[
            'no_doc_paciente.required' => 'El campo Paciente es obligatorio',
            'no_doc_paciente.exists'   => 'No se encontró un registro de paciente que coincida con los datos proporcionados. Es posible que el paciente haya sido eliminado o modificado previamente.',
            'cod_hospital.required'    => 'El campo hospital es obligatorio',
            'cod_hospital.exists'      => 'No se encontró un registro de hospital que coincida con los datos proporcionados. Es posible que el hospital haya sido eliminado o modificado previamente.',
            'fec_ingreso.required'     => 'El campo Fecha ingreso es obligatorio',
            'fec_salida.required'      => 'El campo Fecha salida es obligatorio',
        ]);

        try {
            if ($validator->fails()) {
                return $this->successResponse([
                    'title' => 'Validacion!',
                    'text'  => $validator->errors()->first(),
                    'icon'  => 'warning'
                ], 200);
            }else{
                $tipo_doc_paciente = Paciente::where('no_documento', $request->no_doc_paciente)->value('tipo_documento');
                GestionHospitalaria::where('id_hospitalizacion', $id_hospitalizacion)->update([
                    'tipo_doc_paciente' => $tipo_doc_paciente,
                    'no_doc_paciente'   => $request->no_doc_paciente,
                    'cod_hospital'      => $request->cod_hospital,
                    'fec_ingreso'       => $request->fec_ingreso,
                    'fec_salida'        => $request->fec_salida,
                ]);
                return $this->successResponse([
                    'title' => 'Gestión actualizada!',
                    'text'  => 'Se ha actualizado con éxito la gestión hospitalaria',
                    'icon'  => 'success'
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->successResponse([
                'title' => 'Error!',
                'text'  => $th->getMessage(),
                'icon'  => 'error'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GestionHospitalaria  $gestionHospitalaria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_hospitalizacion)
    {
        try {
            GestionHospitalaria::where('id_hospitalizacion', $id_hospitalizacion)->delete();
            return $this->successResponse([
                'title' => 'Gestión eliminada!',
                'text'  => 'Se ha eliminado con éxito la gestión hospitalaria',
                'icon'  => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return $this->successResponse([
                'title' => 'Error!',
                'text'  => $th->getMessage(),
                'icon'  => 'error'
            ], 200);
        }
    }
}
