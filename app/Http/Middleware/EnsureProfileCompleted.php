<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Cek jika user adalah Klien dan belum melengkapi Profil Perusahaan
        if ($user && $user->role === 'klien') {
            $profile = $user->companyProfile;

            if (!$profile || !$profile->is_completed) {
                return redirect()->route('client.profile.edit')
                    ->with('warning', 'Silakan lengkapi Profil Perusahaan Anda terlebih dahulu sebelum membuat pengajuan.');
            }
        }

        return $next($request);
    }
}
