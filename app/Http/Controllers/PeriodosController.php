<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodosController extends Controller
{
    public function index()
    {
        $periodos = DB::table('periodo')->paginate(6);
        return view('admin.periodos', compact('periodos'));
    }

    public function create(Request $request)
    {
        // Validación con regla unique para el año
        $request->validate([
            'anio' => 'required|unique:periodo,anio',
            'id_usuario' => '',
        ], [

            'anio.unique' => 'Ya existe un periodo registrado para el año :input.',
            'anio.required' => 'El año es requerido.',
        ]);

        // Obtener el administrador
        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;

        try {
            // Insertar el periodo
            DB::table('periodo')->insert([
                'anio' => $request->anio,
                'id_usuario' => $id_admin,
            ]);

            return redirect()->back()->with('success', 'Periodo creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el periodo. Por favor, inténtelo de nuevo.');
        }
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'anio' => 'required',
            'id_usuario' => '',
        ]);

        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;

        DB::table('periodo')->where('id', $id)->update([
            'anio' => $request->anio,
            'id_usuario' => $id_admin,
        ]);

        return redirect()->back()->with('success', 'Periodo actualizado correctamente');
    }

    public function delete($id)
    {
        // Verificar si el periodo tiene eventos asociados
        $eventosAsociados = DB::table('evento')->where('id_periodo', $id)->exists();

        if ($eventosAsociados) {
            return redirect()->back()->with('danger', 'No se puede eliminar el periodo porque tiene eventos asociados.');
        }

        // Eliminar el periodo si no tiene eventos asociados
        DB::table('periodo')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Periodo eliminado correctamente.');
    }
}
