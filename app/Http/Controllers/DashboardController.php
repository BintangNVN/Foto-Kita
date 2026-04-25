<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $total  = $user->photos()->count();
        $today  = $user->photos()->whereDate('created_at', today())->count();
        $recent = $user->photos()->latest()->take(6)->get();

        // Dummy news articles
        $news = [
            [
                'title'   => 'Tips Memotret Landscape yang Memukau',
                'summary' => 'Pelajari teknik komposisi, golden hour, dan pengaturan kamera untuk memotret pemandangan alam yang menakjubkan.',
                'date'    => '25 Apr 2026',
                'icon'    => '<i class="bi bi-mountains text-success"></i>',
            ],
            [
                'title'   => 'Cara Mengedit Foto dengan Lightroom Mobile',
                'summary' => 'Panduan lengkap penggunaan Lightroom Mobile untuk mengedit foto sehari-hari langsung dari smartphone Anda.',
                'date'    => '24 Apr 2026',
                'icon'    => '<i class="bi bi-phone text-primary"></i>',
            ],
            [
                'title'   => 'Street Photography: Seni Mengabadikan Momen',
                'summary' => 'Street photography adalah genre fotografi yang menantang namun sangat memuaskan. Simak tips dari fotografer profesional.',
                'date'    => '23 Apr 2026',
                'icon'    => '<i class="bi bi-camera-reels text-warning"></i>',
            ],
            [
                'title'   => 'Tren Fotografi 2026: AI dan Kreativitas',
                'summary' => 'Bagaimana kecerdasan buatan mengubah dunia fotografi di tahun 2026 dan bagaimana fotografer beradaptasi.',
                'date'    => '22 Apr 2026',
                'icon'    => '<i class="bi bi-robot text-info"></i>',
            ],
        ];

        return view('dashboard', compact('user', 'total', 'today', 'recent', 'news'));
    }
}
