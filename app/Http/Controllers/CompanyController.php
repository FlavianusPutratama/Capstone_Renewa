<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Cari perusahaan berdasarkan nama dan redirect ke halaman detail.
     */
    public function search(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
        ]);

        $company = Company::where('name', 'LIKE', '%' . $request->company_name . '%')->first();

        if (!$company) {
            return redirect()->route('welcome')->with('error', 'Perusahaan tidak ditemukan.');
        }

        return redirect()->route('rec.show.company', ['company' => $company]);
    }

    /**
     * Tampilkan detail perusahaan dan riwayat pembelian REC.
     */
    public function show(Company $company)
    {
        $company->load(['user.orders' => function ($query) {
            $query->where('category', 'Enterprise')->where('status', 'completed')->with('certificates');
        }]);

        return view('company-detail', compact('company'));
    }
}