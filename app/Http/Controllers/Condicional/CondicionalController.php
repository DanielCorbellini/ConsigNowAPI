<?php

namespace App\Http\Controllers\Condicional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CondicionalService;
use App\Http\Requests\Condicional\CondicionalIndexRequest;
use App\Http\Requests\Condicional\CondicionalStoreRequest;
use App\Http\Requests\Condicional\CondicionalUpdateRequest;

class CondicionalController extends Controller
{
    protected $condicionalService;

    public function __construct(CondicionalService $condicionalService)
    {
        $this->condicionalService = $condicionalService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CondicionalIndexRequest $request)
    {
        $validatedConditionals = $request->validated();
        $condicionais = $this->condicionalService->listar($validatedConditionals);

        if ($condicionais->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Condicionais não encontradas'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'condicional' => $condicionais
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CondicionalStoreRequest $request)
    {
        $validatedConditionals = $request->validated();
        $condicional = $this->condicionalService->criar($validatedConditionals);

        if (!$condicional) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar condicional'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Condicional criada com sucesso',
            'condicional' => $condicional
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $condicionais = $this->condicionalService->listarPorId($id);

        if (empty($condicionais)) {
            return response()->json([
                'success' => false,
                'message' => 'Condicional não encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'condicional' => $condicionais
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CondicionalUpdateRequest $request, int $id)
    {
        $validatedConditionals = $request->validated();
        $condicional = $this->condicionalService->editar($id, $validatedConditionals);

        if (!$condicional) {
            return response()->json([
                'success' => false,
                'message' => 'Condicional não encontrada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => $condicional
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deleted = $this->condicionalService->deletar($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível deletar a condicional ou ela não existe'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Condicional deletada com sucesso!'
        ], 200);
    }
}
