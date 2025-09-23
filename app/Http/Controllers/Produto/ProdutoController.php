<?php

namespace App\Http\Controllers\Produto;

use RuntimeException;
use Illuminate\Http\Request;
use App\Services\ProdutoService;
use App\Http\Controllers\Controller;

class ProdutoController extends Controller
{

    protected $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedProduct = $request->validate([
            "descricao" => 'required|string|max:1000',
            "categoria_id" => 'required|exists:categorias_produto,id',
            "preco_custo" => 'required|numeric|decimal:0,2',
            "preco_venda" => 'required|numeric|decimal:0,2',
        ]);

        try {
            $product = $this->produtoService->criarProduto($validatedProduct);
            return response()->json([
                "message" => "Produto cadastrado com sucesso",
                "produto" => $product,
                "success" => true
            ], 200);
        } catch (RuntimeException $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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
