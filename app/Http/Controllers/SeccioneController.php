<?php

namespace App\Http\Controllers;

use App\Models\Seccione;
use Illuminate\Http\Request;

/**
 * Class SeccioneController
 * @package App\Http\Controllers
 */
class SeccioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secciones = Seccione::paginate();

        return view('seccione.index', compact('secciones'))
            ->with('i', (request()->input('page', 1) - 1) * $secciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $seccione = new Seccione();
        return view('seccione.create', compact('seccione'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Seccione::$rules);

        $seccione = Seccione::create($request->all());

        return redirect()->route('alumnos.index')
            ->with('success', 'SECCION REGISTRADA EXITOSAMENTE');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seccione = Seccione::find($id);

        return view('seccione.show', compact('seccione'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seccione = Seccione::find($id);

        return view('seccione.edit', compact('seccione'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Seccione $seccione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seccione $seccione)
    {
        request()->validate(Seccione::$rules);

        $seccione->update($request->all());

        return redirect()->route('secciones.index')
            ->with('success', 'Seccione updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $seccione = Seccione::find($id)->delete();

        return redirect()->route('secciones.index')
            ->with('success', 'Seccione deleted successfully');
    }
}
