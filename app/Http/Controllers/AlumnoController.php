<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoFormRequest;
use App\Http\Resources\AlumnoCollection;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $alumnos = Alumno::all();
//        return (response()->json($alumnos));
        return new AlumnoCollection($alumnos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlumnoFormRequest $request)
    {
        //
        $datos = $request->input("data.attributes");
        $alumno = new Alumno($datos);
        $alumno->save();
        return new AlumnoResource($alumno);
        //return response()->json($alumno,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
        $alumno = Alumno::find($id);
        if (!$alumno){
            return response()->json([
                "errors" => [
                    "status" => "404",
                    "title" => "Resouce not found",
                    "details" => "$id Alumno not found"
                ]
            ],404);
        }
        return new AlumnoResource($alumno);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlumnoFormRequest $request, int $id)
    {
        $alumno = Alumno::find($id);
        if (!$alumno){
            return response()->json([
                "errors" => [
                    "status" => "404",
                    "title" => "Resouce not found",
                    "details" => "$id Alumno not found"
                ]
            ],404);
        }
//        $verbo = $request->method();
//        switch ($verbo){
//            case "PUT":
//                $alumno = new AlumnoFormRequest($alumno);
//                break;
//            case "PATCH":
//
//                break;
//        }
        $alumno->update($request->input("data.attributes"));
        return new AlumnoResource($alumno);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $alumno = Alumno::find($id);
        if (!$alumno){
            return response()->json([
                "errors" => [
                    "status" => "404",
                    "title" => "Resouce not found",
                    "details" => "$id Alumno not found"
                ]
            ],404);
        }
        $alumno->delete();
//        return response()->json(null,204);
        return response()->noContent();
    }
}
