<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Models\Grado;
use App\Models\Seccione;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;
use QrCode;


/**
 * Class AlumnoController
 * @package App\Http\Controllers
 */
class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
        {
            $alumnos = Alumno::all();
            $grados = Grado::pluck('nombre','id');
            $secciones = Seccione::pluck('nombre','id');
            
            return view('alumno.index', compact('alumnos', 'grados', 'secciones'));
        }
    




    public function pdf(Request $request)
{
    $gradoSeccion = $request->input('gradoSeccion');

    // Obtener el grado y la sección del campo `gradoSeccion`
    $grado = explode(' ', $gradoSeccion)[0];
    $seccion = explode(' ', $gradoSeccion)[1];

    // Obtener todos los alumnos del grado y sección seleccionados
    $alumnosGradoSeccion = Alumno::whereHas('grado', function ($query) use ($grado) {
        $query->where('nombre', $grado);
    })->whereHas('seccione', function ($query) use ($seccion) {
        $query->where('nombre', $seccion);
    })->get();

    $qr_codes = [];

    foreach ($alumnosGradoSeccion as $alumno) {
        $qr_code = QrCode::format('png')->size(100)->generate($alumno->id);
        $detail = [
            'code' => $qr_code,
            'Nombre' => $alumno->nombre,
            'Apellido' => $alumno->apellidos,
            'GradoSeccion' => $alumno->grado->nombre . " " . $alumno->seccione->nombre,
        ];
        $qr_codes[] = $detail;
    }

    $data = ['qr_codes' => $qr_codes];
    $pdf = PDF::loadView('alumno.pdf', $data);
    return $pdf->stream('qr_codes.pdf');
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $alumno = new Alumno();
        $grados = Grado::pluck('nombre','id');
        $secciones = Seccione::pluck('nombre','id');
        return view('alumno.create', compact('alumno','grados','secciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Alumno::$rules);

        $alumno = Alumno::create($request->all());

        return redirect()->route('alumnos.index')
            ->with('success', 'SE REGISTRO AL ALUMNO CORRECTAMENTE.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alumno = Alumno::find($id);
        $grados = Grado::pluck('nombre','id');
        $secciones = Seccione::pluck('nombre','id');

        return view('alumno.show', compact('alumno','grados','secciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alumno = Alumno::find($id);
        $grados = Grado::pluck('nombre','id');
        $secciones = Seccione::pluck('nombre','id');
        return view('alumno.edit', compact('alumno','grados','secciones'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Alumno $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumno $alumno)
    {
        request()->validate(Alumno::$rules);

        $alumno->update($request->all());

        return redirect()->route('alumnos.index')
            ->with('success', 'Datos editados correctamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $alumno = Alumno::find($id)->delete();

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno Eliminado exitosamente');
    }
}
