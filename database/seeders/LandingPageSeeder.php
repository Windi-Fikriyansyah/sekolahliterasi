<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandingPageSeeder extends Seeder
{
    public function run()
    {
        // Create Landing Page
        $landingId = DB::table('lp_program')->insertGetId([
            'product_id' => '5',
            'nama_halaman' => 'Indonesia Menulis',
            'slug' => 'indonesia-menulis',
            'hero_title' => 'Indonesia Menulis',
            'hero_subtitle' => 'Wujudkan mimpi Anda menjadi penulis profesional bersama komunitas penulis terbesar di Indonesia',
            'hero_button_text' => 'Daftar Sekarang',
            'hero_button_link' => '#daftar',
            'hero_color_start' => '#667eea',
            'hero_color_end' => '#764ba2',
            'primary_color' => '#667eea',
            'secondary_color' => '#764ba2',
            'footer_text' => '© 2024 Indonesia Menulis. Semua hak dilindungi.',
            'footer_contact' => 'info@indonesiamenulis.id',
            'footer_phone' => '+62 812-3456-7890',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create Info Cards Section
        DB::table('landing_sections_program')->insert([
            'landing_page_id' => $landingId,
            'section_type' => 'info_cards',
            'section_title' => 'Mengapa Indonesia Menulis?',
            'order' => 1,
            'content' => json_encode([
                [
                    'icon' => '📚',
                    'title' => 'Pembelajaran Terstruktur',
                    'description' => 'Program pembelajaran menulis yang terstruktur dari dasar hingga mahir, dipandu oleh penulis profesional dan editor berpengalaman.'
                ],
                [
                    'icon' => '👥',
                    'title' => 'Komunitas Aktif',
                    'description' => 'Bergabung dengan ribuan penulis dari seluruh Indonesia. Saling berbagi, belajar, dan berkembang bersama.'
                ],
                [
                    'icon' => '🏆',
                    'title' => 'Peluang Publikasi',
                    'description' => 'Kesempatan untuk menerbitkan karya Anda melalui berbagai platform dan penerbit yang bekerjasama dengan kami.'
                ],
                [
                    'icon' => '💡',
                    'title' => 'Mentor Berpengalaman',
                    'description' => 'Bimbingan langsung dari penulis bestseller dan praktisi industri penerbitan yang siap membantu perjalanan menulis Anda.'
                ],
                [
                    'icon' => '📝',
                    'title' => 'Workshop Rutin',
                    'description' => 'Workshop dan webinar rutin dengan berbagai tema menarik untuk mengasah kemampuan menulis Anda.'
                ],
                [
                    'icon' => '🎯',
                    'title' => 'Sertifikat Resmi',
                    'description' => 'Dapatkan sertifikat resmi setelah menyelesaikan program yang dapat memperkuat portofolio Anda.'
                ]
            ]),
            'settings' => json_encode([]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create Gallery Section
        DB::table('landing_sections_program')->insert([
            'landing_page_id' => $landingId,
            'section_type' => 'gallery',
            'section_title' => 'Galeri Kegiatan',
            'order' => 2,
            'content' => json_encode([
                ['image' => 'Workshop Menulis Kreatif', 'caption' => 'Workshop Menulis Kreatif'],
                ['image' => 'Pertemuan Komunitas', 'caption' => 'Pertemuan Komunitas'],
                ['image' => 'Peluncuran Buku Anggota', 'caption' => 'Peluncuran Buku Anggota'],
                ['image' => 'Sesi Mentoring', 'caption' => 'Sesi Mentoring'],
                ['image' => 'Seminar Penerbitan', 'caption' => 'Seminar Penerbitan'],
                ['image' => 'Kompetisi Menulis', 'caption' => 'Kompetisi Menulis']
            ]),
            'settings' => json_encode([]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create Video Section
        DB::table('landing_sections_program')->insert([
            'landing_page_id' => $landingId,
            'section_type' => 'video',
            'section_title' => 'Profil Indonesia Menulis',
            'order' => 3,
            'content' => json_encode([
                'video_url' => '',
                'video_title' => 'Video Profil Indonesia Menulis',
                'video_description' => 'Temukan perjalanan para penulis sukses dari komunitas kami'
            ]),
            'settings' => json_encode([]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create Form Section
        DB::table('landing_sections_program')->insert([
            'landing_page_id' => $landingId,
            'section_type' => 'form',
            'section_title' => 'Formulir Pendaftaran',
            'order' => 4,
            'content' => json_encode([
                [
                    'label' => 'Nama Lengkap',
                    'type' => 'text',
                    'name' => 'nama',
                    'required' => true
                ],
                [
                    'label' => 'Email',
                    'type' => 'email',
                    'name' => 'email',
                    'required' => true
                ],
                [
                    'label' => 'Nomor Telepon',
                    'type' => 'tel',
                    'name' => 'telepon',
                    'required' => true
                ],
                [
                    'label' => 'Kota',
                    'type' => 'text',
                    'name' => 'kota',
                    'required' => true
                ],
                [
                    'label' => 'Pilih Program',
                    'type' => 'select',
                    'name' => 'program',
                    'required' => true
                ],
                [
                    'label' => 'Pengalaman Menulis',
                    'type' => 'textarea',
                    'name' => 'pengalaman',
                    'required' => false
                ],
                [
                    'label' => 'Motivasi Bergabung',
                    'type' => 'textarea',
                    'name' => 'motivasi',
                    'required' => false
                ]
            ]),
            'settings' => json_encode([]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Landing page seeder completed successfully!');
    }
}
