<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreviewUiController extends Controller
{
    /**
     * Programmatically simulate logged-in session as Pembina OSIS
     * so that all auth checks, roles, and UI elements render completely.
     */
    private function simulateAdmin(): void
    {
        $user = User::where('role', 'pembina')->first()
             ?? User::where('role', 'dewan_harian')->first()
             ?? User::first();

        if ($user) {
            Auth::setUser($user);
        }
    }

    /**
     * Directory / Hub of all preview links for Figma conversion
     */
    public function index()
    {
        $this->simulateAdmin();
        return view('preview.index');
    }

    public function dashboard(Request $request)
    {
        $this->simulateAdmin();
        return (new KegiatanController)->index($request);
    }

    public function monitoring(Request $request)
    {
        $this->simulateAdmin();
        return (new MonitoringController)->index($request);
    }

    public function pelanggaran()
    {
        $this->simulateAdmin();
        return (new PelanggaranGdsController)->index();
    }

    public function absensi()
    {
        $this->simulateAdmin();
        return (new AbsensiGdsController)->index();
    }

    public function piket()
    {
        $this->simulateAdmin();
        return (new PiketController)->index();
    }

    public function keuangan()
    {
        $this->simulateAdmin();
        return (new KeuanganController)->index();
    }
}
