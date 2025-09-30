<?php

namespace App\Services;

use App\Models\Condicional;
use Illuminate\Database\Eloquent\Collection;

class CondicionalService
{
    public function criar(array $data): ?Condicional
    {
        return Condicional::create($data);
    }

    public function listar(array $filtros = []): Collection
    {
        return Condicional::comRepresentante($filtros)->get();
    }

    public function listarPorId(int $id)
    {
        return Condicional::find($id);
    }

    public function editar(int $id, array $data): ?Condicional
    {
        $condicional = Condicional::find($id);

        // Mudar
        if (!$condicional)
            return null;

        $condicional->update($data);

        //Ajustar
        return $condicional->fresh(['representante.user']);
    }

    public function deletar(int $id): bool
    {
        return Condicional::destroy($id) > 0;
    }
}
