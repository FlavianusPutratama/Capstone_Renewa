<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')
            ->whereIn('role', ['issuer', 'generator'])
            ->orderBy('created_at', 'asc')
            ->get();

        $stats = [
            'approved' => User::where('status', 'approved')->where('role', '!=', 'admin')->count(),
            'total' => User::where('role', '!=', 'admin')->count(),
        ];
        
        return view('admin.dashboard', compact('pendingUsers', 'stats'));
    }

    /**
     * Mengambil detail pengguna dalam format JSON untuk modal.
     */
    public function getJsonDetails($userId)
    {
        try {
            // Gunakan findOrFail dan eager load relasi yang mungkin ada
            $user = User::with(['powerPlants', 'issuerProfile'])->findOrFail($userId);

            if ($user->status !== 'pending') {
                return response()->json(['error' => 'Pengguna ini tidak memerlukan verifikasi.'], 404);
            }

            // Siapkan data dasar
            $dataToReturn = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'approve_url' => route('admin.users.approve', $user->id),
                'reject_url' => route('admin.users.reject', $user->id),
            ];

            // Tambahkan data spesifik berdasarkan peran
            if ($user->role === 'issuer' && $user->issuerProfile) {
                $profile = $user->issuerProfile;
                $dataToReturn['company_name'] = $profile->company_name;
                $dataToReturn['nib'] = $profile->nib;
                $dataToReturn['document_url'] = Storage::url($profile->legal_document_path);
                $dataToReturn['document_label'] = 'Dokumen Legalitas';
            } 
            elseif ($user->role === 'generator') {
                $powerPlant = $user->powerPlants->first();
                if ($powerPlant) {
                    $dataToReturn['power_plant_name'] = $powerPlant->name;
                    $dataToReturn['energy_type'] = $powerPlant->energy_type;
                    $dataToReturn['capacity'] = $powerPlant->capacity . ' MW';
                    $dataToReturn['document_url'] = Storage::url($powerPlant->operational_permit_path);
                    $dataToReturn['document_label'] = 'Izin Operasi';
                }
            }

            return response()->json($dataToReturn);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan di server: ' . $e->getMessage()], 500);
        }
    }

    public function approve($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = 'approved';
        $user->email_verified_at = now();
        $user->save();
        return redirect()->route('admin.dashboard')->with('success', 'Akun ' . $user->name . ' telah berhasil disetujui.');
    }

    public function reject(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->status = 'rejected';
        $user->save();
        return redirect()->route('admin.dashboard')->with('success', 'Pendaftaran ' . $user->name . ' telah ditolak.');
    }
}