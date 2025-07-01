<?php

namespace App\Http\Controllers\Issuer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Display the issuer registration view.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('issuer.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'nib' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'], // Nama PIC
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'legal_document' => ['required', 'file', 'mimes:pdf', 'max:2048'], // Validasi file PDF maks 2MB
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        // Simpan dokumen yang diunggah ke disk 'public'
        // Ini akan menyimpan file di storage/app/public/issuer_documents
        $documentPath = $request->file('legal_document')->store('issuer_documents', 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'issuer',
            'status' => 'pending',
            // Anda perlu menambahkan kolom baru di migrasi dan model User jika belum ada.
            // Contoh: 'legal_document_path' => $documentPath,
            // 'company_name' => $request->company_name,
            // 'nib' => $request->nib,
        ]);

        // Simpan data tambahan ke tabel terpisah atau tambahkan kolom di tabel 'users'
        // Contoh:
        // $user->issuerProfile()->create([
        //     'company_name' => $request->company_name,
        //     'nib' => $request->nib,
        //     'legal_document_path' => $documentPath,
        // ]);


        return redirect()->route('login')->with('status', 'Pendaftaran Anda telah diterima. Akun akan diaktifkan setelah proses verifikasi oleh administrator selesai.');
    }
}
