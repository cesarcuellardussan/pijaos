<?php

namespace App\Http\Controllers;

use App\Models\GestionHospitalaria;
use App\Models\Hospital;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $hospitales = Hospital::get();
            $data = array();
            foreach ($hospitales as $key => $hospital) {
                $acciones = '<button class="btn btn-sm btn-warning shadow" onclick="editHospital(\''.$hospital->cod_hospital.'\')"><i class="fas fa-edit"></i> Editar</button>
                            <button class="btn btn-sm btn-danger shadow" onclick="deleteHospital(\''.$hospital->cod_hospital.'\')"><i class="fas fa-trash-alt"></i> Eliminar</button>';
                $data[] = [
                    'fec_creacion' => $hospital->created_at->format('Y-m-d H:i:s'),
                    'cod_hospital' => $hospital->cod_hospital,
                    'nombre'       => $hospital->nombre,
                    'action'       => $acciones
                ];
            }
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
        return view('hospitales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'cod_hospital' => 'required|numeric|digits_between:1,12|unique:hospitales,cod_hospital',
            // 'cod_hospital' => [
            //     'required',
            //     'numeric',
            //     'digits_between:1,12',
            //     Rule::unique('hospitales')->where(function ($query) {
            //         return $query->whereNull('deleted_at');
            //     })
            // ],
            'nombre_hospital' => 'required|string|max:100|unique:hospitales,nombre'
        ],[
            'cod_hospital.required'       => 'El campo código es obligatorio',
            'cod_hospital.numeric'        => 'El campo código debe ser numérico',
            'cod_hospital.digits_between' => 'El campo código debe tener entre 1 y 12 dígitos.',
            'cod_hospital.unique'         => 'El código del hospital ingresado ya está en uso',
            'nombre_hospital.required'    => 'El campo nombre del hospital es obligatorio',
            'nombre_hospital.string'      => 'El campo nombre del hospital debe ser una cadena de caracteres',
            'nombre_hospital.max'         => 'El campo nombre del hospital no debe superar los 100 caracteres',
            'nombre_hospital.unique'      => 'El nombre del hospital ingresado ya está en uso',
        ]);

        try {
            if ($validator->fails()) {
                // return $this->errorResponse($validator->errors()->first(), 400);
                return $this->successResponse([
                    'title' => 'Validacion!',
                    'text'  => $validator->errors()->first(),
                    'icon'  => 'warning'
                ], 200);
            }else{
                Hospital::create([
                    "cod_hospital" => $request->cod_hospital,
                    "nombre"       => mb_strtoupper($request->nombre_hospital, 'UTF-8')
                ]);

                return $this->successResponse([
                    'title' => 'Hospital creado!',
                    'text'  => 'Se ha creado con éxito el hospital',
                    'icon'  => 'success'
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->successResponse([
                'title' => 'Error!',
                'text'  => $th->getMessage(),
                'icon'  => 'error'
            ], 200);
            // return $this->errorResponse('Ocurrio un error al intentar crear el recurso. Detalle: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show(Hospital $hospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit($cod_hospital)
    {
        try {
            return Hospital::where("cod_hospital",$cod_hospital)->first();
        } catch (\Throwable $th) {
            return $this->errorResponse('Ocurrio un error al intentar crear el recurso. Detalle: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cod_hospital)
    {
        $validator = Validator::make($request->all(), [
            'cod_hospital' => [
                'required',
                'numeric',
                'digits_between:1,12',
                Rule::unique('hospitales')->ignore($cod_hospital, 'cod_hospital')
            ],
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('hospitales')->ignore(mb_strtoupper($request->nombre_hospital, 'UTF-8'), 'nombre')
            ],
        ],[
            'cod_hospital.required'       => 'El campo código es obligatorio',
            'cod_hospital.numeric'        => 'El campo código debe ser numérico',
            'cod_hospital.digits_between' => 'El campo código debe tener entre 1 y 12 dígitos.',
            'cod_hospital.unique'         => 'El código del hospital ingresado ya está en uso',
            'nombre.required'             => 'El campo nombre del hospital es obligatorio',
            'nombre.string'               => 'El campo nombre del hospital debe ser una cadena de caracteres',
            'nombre.max'                  => 'El campo nombre del hospital no debe superar los 100 caracteres',
            'nombre.unique'               => 'El nombre del hospital ingresado ya está en uso',
        ]);

        try {
            if ($validator->fails()) {
                return $this->successResponse([
                    'title' => 'Validacion!',
                    'text'  => $validator->errors()->first(),
                    'icon'  => 'warning'
                ], 200);
            }else{
                $Hospital = Hospital::where('cod_hospital', $cod_hospital)->first();
                if ($Hospital->gestionHospitalarias()->exists() && $request->cod_hospital != $cod_hospital) {
                    return $this->successResponse([
                        'title' => 'Validacion!',
                        'text'  => 'No se puede actualizar el hospital porque tiene registros en GESTIÓN HOSPITALARIA',
                        'icon'  => 'warning'
                    ], 200);
                }else{
                    Hospital::where('cod_hospital',$cod_hospital)->update([
                        "cod_hospital" => $request->cod_hospital,
                        "nombre"       => mb_strtoupper($request->nombre, 'UTF-8')
                    ]);

                    return $this->successResponse([
                        'title' => 'Hospital actualizado!',
                        'text'  => 'Se ha actualizado con éxito el hospital',
                        'icon'  => 'success'
                    ], 200);
                }
            }
        } catch (\Throwable $th) {
            ($request->cod_hospital !== $cod_hospital)? $oli = "true" : $oli = "false";
            return $this->successResponse([
                'title' => 'Error!',
                'text'  => $oli." request->cod_hospital -> ".$request->cod_hospital." ".gettype($request->cod_hospital)."   ,cod_hospital -> ".$cod_hospital." ".gettype($cod_hospital)."-----".$th->getMessage(),
                'icon'  => 'error'
            ], 200);
            // return $this->errorResponse('Ocurrio un error al intentar crear el recurso. Detalle: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy($cod_hospital)
    {
        try {
            $Hospital = Hospital::where('cod_hospital', $cod_hospital)->first();
            if ($Hospital->gestionHospitalarias()->exists()) {
                return $this->successResponse([
                    'title' => 'Validacion!',
                    'text'  => 'No se puede eliminar el hospital porque tiene registros en GESTIÓN HOSPITALARIA',
                    'icon'  => 'warning'
                ], 200);
            }else{
                Hospital::where('cod_hospital', $cod_hospital)->delete();
                return $this->successResponse([
                    'title' => 'Hospital eliminado!',
                    'text'  => 'Se ha eliminado con éxito el hospital',
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
}
