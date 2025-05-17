<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{

    private function abortIfNotAdmin(Request $request)
    {
    }

public function index(Request $request)
{
    $this->abortIfNotAdmin($request);

    $query = User::query();

    if ($request->filled('city')) {
        $query->where('city', 'like', "%{$request->city}%");
    }

    if ($request->filled('state')) {
        $query->where('state', 'like', "%{$request->state}%");
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', "%{$request->email}%");
    }

    $paginated = $query->orderBy('name')->paginate(10);

    $metrics = [
        'total_users' => $query->count(),
        'by_city' => $query->clone()->select('city')->groupBy('city')->selectRaw('city, count(*) as total')->get(),
        'by_state' => $query->clone()->select('state')->groupBy('state')->selectRaw('state, count(*) as total')->get(),
    ];

    return response()->json([
        'users' => UserResource::collection($paginated),
        'meta' => $paginated->toArray()['meta'],
        'metrics' => $metrics,
    ]);
}

    public function destroy(Request $request, $id)
    {
        $this->abortIfNotAdmin($request);

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso.']);
    }
}
