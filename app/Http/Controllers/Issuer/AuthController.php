<?php

namespace App\Http\Controllers\Issuer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules; // <<< penting untuk Rules\Password::defaults()

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
            'company_name'   => ['required', 'string', 'max:255'],
            'nib'            => ['required', 'string', 'max:255'],
            'name'           => ['required', 'string', 'max:255'], // Nama PIC
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'          => ['required', 'string', 'max:15'],
            'legal_document' => ['required', 'file', 'mimes:pdf', 'max:2048'], // max 2MB
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'terms'          => ['required', 'accepted'],
        ]);

        DB::transaction(function () use ($request) {
            // 1) Buat user issuer dengan status pending
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,   // hapus baris ini jika kolom phone tidak ada
                'password' => Hash::make($request->password),
                'role'     => 'issuer',
                'status'   => 'pending',
            ]);

            // 2) Upload PDF -> simpan RELATIVE PATH (contoh: issuer_documents/abc.pdf)
            $path = $request->file('legal_document')->store('issuer_documents', 'public');

            // 3) Buat/isi issuer profile terkait user
            $user->issuerProfile()->create([
                'company_name'        => $request->company_name,
                'nib'                 => $request->nib,
                'legal_document_path' => $path, // simpan path relatif
            ]);
        }); // <<< pastikan blok transaksi tertutup

        return redirect()
            ->route('login')
            ->with('status', 'Pendaftaran Anda telah diterima. Akun akan diaktifkan setelah verifikasi admin.');
    }
}
