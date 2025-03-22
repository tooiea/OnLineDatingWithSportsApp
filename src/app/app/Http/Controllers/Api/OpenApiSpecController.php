<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpenApiSpecResource;
use App\Models\OpenApiSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OpenApiSpecController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(OpenApiSpec::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|json',
        ]);

        $spec = OpenApiSpec::create($validated);
        return response()->json($spec, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OpenApiSpec $openApiSpec)
    {
        return new OpenApiSpecResource($openApiSpec);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OpenApiSpec $openApiSpec)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'content' => 'sometimes|json',
        ]);

        $openApiSpec->update($validated);
        return response()->json($openApiSpec);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpenApiSpec $openApiSpec)
    {
        $openApiSpec->delete();
        return response()->json(null, 204);
    }
}
