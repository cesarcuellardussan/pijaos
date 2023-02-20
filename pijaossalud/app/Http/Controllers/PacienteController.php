<?php

namespace App\Http\Controllers;

use App\Models\GestionHospitalaria;
use App\Models\Paciente;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pacientes = Paciente::get();
            $data = array();
            foreach ($pacientes as $key => $paciente) {
                $acciones = '<button class="btn btn-sm btn-warning shadow" onclick="editPaciente(\''.$paciente->no_documento.'\')"><i class="fas fa-edit"></i> Editar</button>
                            <button class="btn btn-sm btn-danger shadow" onclick="deletePaciente(\''.$paciente->no_documento.'\')"><i class="fas fa-trash-alt"></i> Eliminar</button>';
                $data[] = [
                    'fec_creacion'   => $paciente->created_at->format('Y-m-d H:i:s'),
                    'tipo_documento' => $paciente->tipo_documento,
                    'no_documento'   => $paciente->no_documento,
                    'nombres'        => $paciente->nombres,
                    'apellidos'      => $paciente->apellidos,
                    'fec_nacimiento' => $paciente->fec_nacimiento,
                    'email'          => $paciente->email,
                    'action'         => $acciones
                ];
            }
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
        return view('pacientes.index');
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
            'tipo_documento' => 'required|max:2',
            // 'no_documento'   => 'required|max:15|unique:pacientes,no_documento,NULL,id,tipo_documento,'.$request->tipo_documento,
            'no_documento'   => 'required|max:15|unique:pacientes,no_documento',
            'nombres'        => 'required|max:255',
            'apellidos'      => 'required|max:255',
            'fec_nacimiento' => 'required|date',
            'email'          => 'required|email'
        ],[
            'no_documento.unique' => 'El número de documento del paciente ingresado ya está en uso',
        ]);

        try {
            if ($validator->fails()) {
                return $this->successResponse([
                    'title' => 'Validacion!',
                    'text'  => $validator->errors()->first(),
                    'icon'  => 'warning'
                ], 200);
            }else{
                Paciente::create([
                    "tipo_documento" => $request->tipo_documento,
                    "no_documento"   => mb_strtoupper($request->no_documento, 'UTF-8'),
                    "nombres"        => mb_strtoupper($request->nombres, 'UTF-8'),
                    "apellidos"      => mb_strtoupper($request->apellidos, 'UTF-8'),
                    "fec_nacimiento" => $request->fec_nacimiento,
                    "email"          => $request->email
                ]);

                return $this->successResponse([
                    'title' => 'Paciente creado!',
                    'text'  => 'Se ha creado con éxito el Paciente',
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
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show(Paciente $paciente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function edit($no_documento)
    {
        try {
            return Paciente::where("no_documento",$no_documento)->first();
        } catch (\Throwable $th) {
            return $this->errorResponse('Ocurrio un error al intentar crear el recurso. Detalle: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_documento)
    {
        $validator = Validator::make($request->all(), [
            'tipo_documento' => 'required|max:2',
            'no_documento' => [
                'required',
                'max:15',
                Rule::unique('pacientes')->ignore(mb_strtoupper($no_documento, 'UTF-8'), 'no_documento')
            ],
            'nombres'        => 'required|max:255',
            'apellidos'      => 'required|max:255',
            'fec_nacimiento' => 'required|date',
            'email'          => 'required|email'
        ],[
            'no_documento.unique' => 'El número de documento del paciente ingresado ya está en uso',
        ]);

        try {
            if ($validator->fails()) {
                return $this->successResponse([
                    'title' => 'Validacion!',
                    'text'  => $validator->errors()->first(),
                    'icon'  => 'warning'
                ], 200);
            }else{

                $Paciente = Paciente::where('no_documento', $no_documento)->first();
                if ($Paciente->gestionHospitalarias()->exists() && $request->no_documento !== $no_documento) {
                    return $this->successResponse([
                        'title' => 'Validacion!',
                        'text'  => 'No se puede actualizar el documento del paciente porque tiene registros en GESTIÓN HOSPITALARIA',
                        'icon'  => 'warning'
                    ], 200);
                }else{
                    Paciente::where('no_documento', $no_documento)->update([
                        "tipo_documento" => $request->tipo_documento,
                        "no_documento"   => mb_strtoupper($request->no_documento, 'UTF-8'),
                        "nombres"        => mb_strtoupper($request->nombres, 'UTF-8'),
                        "apellidos"      => mb_strtoupper($request->apellidos, 'UTF-8'),
                        "fec_nacimiento" => $request->fec_nacimiento,
                        "email"          => $request->email
                    ]);

                    return $this->successResponse([
                        'title' => 'Paciente actualizado!',
                        'text'  => 'Se ha actualizado con éxito el paciente',
                        'icon'  => 'success'
                    ], 200);
                }
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
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_documento)
    {
        try {
            $Paciente = Paciente::where('no_documento', $no_documento)->first();
            if ($Paciente->gestionHospitalarias()->exists()) {
                return $this->successResponse([
                    'title' => 'Validacion!',
                    'text'  => 'No se puede eliminar el paciente porque tiene registros en GESTIÓN HOSPITALARIA',
                    'icon'  => 'warning'
                ], 200);
            }else{
                Paciente::where('no_documento', $no_documento)->delete();
                return $this->successResponse([
                    'title' => 'Paciente eliminado!',
                    'text'  => 'Se ha eliminado con éxito el paciente',
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
