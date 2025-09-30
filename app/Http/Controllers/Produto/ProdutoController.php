<?php

namespace App\Http\Controllers\Produto;

use RuntimeException;
use App\Services\ProdutoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;

class ProdutoController extends Controller
{

    protected $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    public function index()
    {
        $produtos = $this->produtoService->listarProdutos();

        if ($produtos->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Produtos não encontrados'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'produto' => $produtos
        ], 200);
    }

    public function store(ProdutoRequest $request)
    {
        $validatedProduct = $request->validated();

        try {
            $product = $this->produtoService->criarProduto($validatedProduct);
            return response()->json([
                "message" => "Produto cadastrado com sucesso",
                "produto" => $product,
                "success" => true
            ], 201);
        } catch (RuntimeException $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 500);
        }
    }

    public function show(int $id)
    {
        $produto = $this->produtoService->listarProduto($id);

        if (!$produto) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'produto' => $produto
        ], 200);
    }

    public function update(ProdutoRequest $request, int $id)
    {
        $validatedProduct = $request->validated();
        $produto = $this->produtoService->editarProduto($id, $validatedProduct);

        if (!$produto) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'produto' => $produto
        ], 200);
    }

    public function destroy(int $id)
    {
        $deleted = $this->produtoService->deletarProduto($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível deletar o produto ou ele não existe'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produto deletado com sucesso!'
        ], 200);
    }
}
