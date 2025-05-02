<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * トップページ
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        if ($user) {
            $user->loadMissing('teamMember.team');
        }

        return Inertia::render('TopPage', [
            'isAuthenticated' => Auth::check(),
            'routes' => [
                'login' => route('login.index'),
                'logout' => route('logout'),
                'my_profile' => route('my-profile.detail'),
                'myteam_index' => route('myteam.index'),
                'myteam_detail' => route('myteam.detail'),
                'team_list' => route('team.list'),
                'temp_register_team' => route('temp_register.team.index'),
            ],
            // トップページ用で認証情報を上書き
            'user' => $user? [
                'name' => $user?->name,
                'email' => $user?->email,
                'image_path' => $user?->image?->path_base64,
                'team' => $user?->teamMember?->team ? [
                    'name' => $user?->teamMember->team->name,
                ] : null,
            ] : null,
        ]);
    }
}
