<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;
use App\Models\Grado;
use App\Models\Seccione;
use App\Models\Alumno;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


/**
 * Class AsistenciaController
 * @package App\Http\Controllers
 */
class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    // Obtén la zona horaria de Lima, Perú
    $limaTimezone = new \DateTimeZone('America/Lima');
    
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    
    // Verifica si se proporcionaron fechas
    if ($start_date && $end_date) {
        // Si las fechas son iguales, busca registros para el día específico
        if ($start_date === $end_date) {
            $asistencias = Asistencia::whereDate('fecha', $start_date)->get();
        } else {
            // Si las fechas son diferentes, busca registros dentro del rango de fechas proporcionado
            $asistencias = Asistencia::whereBetween('fecha', [$start_date, $end_date])->get();
        }
    } else {
        // Si no se proporcionaron fechas, utiliza la semana actual
        $startOfWeek = Carbon::now($limaTimezone)->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now($limaTimezone)->endOfWeek()->format('Y-m-d');
        
        // Obtiene los registros de asistencia dentro del rango de la semana actual
        $asistencias = Asistencia::whereBetween('fecha', [$startOfWeek, $endOfWeek])->get();
    }
    
    // Devuelve la vista 'asistencia.index' y pasa los registros de asistencia como variable
    return view('asistencia.index', compact('asistencias'));
}






    public function camara(){
        return view ('asistencia.camara', compact('asistencias'));
    }





    public function diariopdf(Request $request)
{
    $gradoSeccion = $request->input('gradoSeccion');

    // Obtener el grado y la sección del campo `gradoSeccion`
    $words = explode(' ', $gradoSeccion);
    $grado = $words[0];
    $seccion = $words[1];

    // Obtener la fecha de inicio y la fecha de fin de los parámetros
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'));

    // Obtener todos los alumnos que coinciden con la selección
    $alumnos = Alumno::whereHas('grado', function ($query) use ($grado) {
        $query->where('nombre', $grado);
    })->whereHas('seccione', function ($query) use ($seccion) {
        $query->where('nombre', $seccion);
    })->get();

    // Los datos a enviar a la vista
    $data = [
        'alumnos' => $alumnos,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'today' => Carbon::now(),
    ];

    $pdf = PDF::loadView('asistencia.diariopdf', $data);

    return $pdf->stream('Reporte_de_Asistencia.pdf');
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asistencia = new Asistencia();
        return view('asistencia.create', compact('asistencia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    // Obtén el alumno asociado al ID proporcionado en la solicitud
    $alumno = Alumno::find($request->alumno_id);

    // Verifica si el alumno no fue encontrado en la base de datos
    if (!$alumno) {
        return response()->json(['success' => false, 'message' => 'INSERTE CARNET VÁLIDO.']);
    }

    // Obtén la zona horaria de Lima, Perú
    $limaTimezone = new \DateTimeZone('America/Lima');

    // Crea instancias de Carbon utilizando la zona horaria de Lima
    $fecha = Carbon::now($limaTimezone)->format('Y-m-d');

    // Verifica si ya existe una asistencia para el mismo alumno en la misma fecha
    $asistenciaExistente = Asistencia::where('alumno_id', $request->alumno_id)
        ->whereDate('fecha', $fecha)
        ->count();

    // Si ya existe una asistencia para el mismo alumno en la misma fecha, devuelve una respuesta de error
    if ($asistenciaExistente > 0) {
        return response()->json(['success' => false, 'message' => 'YA ESTAS REGISTRADO.']);
    }

    // Calcula el inicio y final de la semana actual en base a la fecha actual
    $startOfWeek = Carbon::now($limaTimezone)->startOfWeek()->format('Y-m-d');
    $endOfWeek = Carbon::now($limaTimezone)->endOfWeek()->format('Y-m-d');

    // Construye un arreglo con los datos de la asistencia
    $registro = [
        'alumno_id' => $request->alumno_id,
        'grado_id' => $alumno->grado_id,
        'seccion_id' => $alumno->seccion_id,
        'fecha' => $fecha,
        'hora' => Carbon::now($limaTimezone),
        'fecha_inicio' => $startOfWeek,
        'fecha_fin' => $endOfWeek,
    ];

    // Crea un nuevo registro de asistencia usando el modelo Asistencia y los datos proporcionados
    Asistencia::create($registro);

    // Devuelve una respuesta de éxito
    return response()->json(['success' => true, 'message' => 'ASISTENCIA REGISTRADA.']);
}




    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asistencia = Asistencia::find($id);

        return view('asistencia.show', compact('asistencia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asistencia = Asistencia::find($id);

        return view('asistencia.edit', compact('asistencia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Asistencia $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        request()->validate(Asistencia::$rules);

        $asistencia->update($request->all());

        return redirect()->route('asistencias.index')
            ->with('success', 'Asistencia updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $asistencia = Asistencia::find($id)->delete();

        return redirect()->route('asistencias.index')
            ->with('success', 'Asistencia deleted successfully');
    }
}