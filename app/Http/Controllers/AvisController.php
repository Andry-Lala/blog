<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    //
    public function envoyerAvis(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'avis' => 'required|string',
        ]);

        Avis::create([
            'email' => $request->email,
            'avis' => $request->avis,
        ]);

        return response()->json(['message' => 'Merci pour votre avis !']);
    }

    public function index()
    {
        $avis = Avis::orderBy('created_at', 'desc')->get();
        return view('admin.avis', compact('avis'));
    }

    public function destroy($id)
    {
        $avis = Avis::findOrFail($id);
        $avis->delete();

        return redirect()->route('admin.avis.index')->with('success', 'Avis supprimé avec succès.');
    }

}
