<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Support\Facades\Auth;

class InvestmentImageController extends Controller
{
    /**
     * Afficher la photo d'identité d'un investissement
     */
    public function showIdPhoto(Investment $investment)
    {
        // Vérifier si l'utilisateur a le droit de voir cette image
        if (Auth::id() !== $investment->user_id && ! Auth::user()->isAdmin) {
            abort(403, 'Unauthorized');
        }

        if (! $investment->id_photo) {
            abort(404, 'Image not found');
        }

        $path = storage_path('app/public/'.$investment->id_photo);

        if (! file_exists($path)) {
            abort(404, 'Image not found');
        }

        $mimeType = mime_content_type($path);
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ];

        return response()->file($path, $headers);
    }

    /**
     * Afficher la preuve de transaction d'un investissement
     */
    public function showTransactionProof(Investment $investment)
    {
        // Vérifier si l'utilisateur a le droit de voir cette image
        if (Auth::id() !== $investment->user_id && ! Auth::user()->isAdmin) {
            abort(403, 'Unauthorized');
        }

        if (! $investment->transaction_proof) {
            abort(404, 'Image not found');
        }

        $path = storage_path('app/public/'.$investment->transaction_proof);

        if (! file_exists($path)) {
            abort(404, 'Image not found');
        }

        $mimeType = mime_content_type($path);
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ];

        return response()->file($path, $headers);
    }
}
