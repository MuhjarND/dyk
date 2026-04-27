<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProfilePagesTable extends Migration
{
    public function up()
    {
        Schema::create('profile_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('profile_pages')->insert([
            [
                'title' => 'Profil Cabang',
                'slug' => 'profil-cabang',
                'excerpt' => 'Gambaran umum Dharmayukti Karini Cabang Papua Barat.',
                'content' => '<p>Dharmayukti Karini Cabang Papua Barat merupakan bagian dari organisasi wanita peradilan di bawah naungan Mahkamah Agung Republik Indonesia.</p><p>Cabang Papua Barat hadir sebagai wadah silaturahmi, pemberdayaan anggota, penguatan nilai moral, serta pengabdian sosial organisasi di wilayah Papua Barat.</p><p>Melalui website ini, masyarakat dan anggota dapat mengikuti informasi resmi mengenai kegiatan, program kerja, serta perkembangan organisasi di tingkat cabang.</p>',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Visi dan Misi',
                'slug' => 'visi-misi',
                'excerpt' => 'Arah organisasi dalam membangun solidaritas dan integritas anggota.',
                'content' => '<h2>Visi</h2><p>Menjadi organisasi wanita peradilan yang profesional, mandiri, dan berintegritas dalam memperkuat solidaritas anggota serta mendukung nilai-nilai moral lembaga peradilan.</p><h2>Misi</h2><ol><li>Meningkatkan ketakwaan kepada Tuhan Yang Maha Esa.</li><li>Mempererat tali silaturahmi antar anggota Dharmayukti Karini Cabang Papua Barat.</li><li>Meningkatkan peran serta dalam kegiatan sosial dan pemberdayaan anggota.</li><li>Memperkuat nilai moral dan integritas di lingkungan lembaga peradilan.</li><li>Meningkatkan keterampilan dan kemandirian anggota.</li><li>Berpartisipasi aktif dalam pembangunan nasional.</li><li>Meningkatkan kesejahteraan anggota dan keluarga besar peradilan.</li></ol>',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'excerpt' => 'Susunan organisasi Dharmayukti Karini dari pusat hingga cabang.',
                'content' => '<p>Dharmayukti Karini Cabang Papua Barat berada dalam struktur organisasi Dharmayukti Karini yang berjenjang dari pusat hingga cabang.</p><ul><li><strong>Pengurus Pusat</strong>: tingkat Mahkamah Agung RI.</li><li><strong>Pengurus Daerah</strong>: tingkat badan peradilan wilayah.</li><li><strong>Pengurus Cabang</strong>: tingkat pengadilan dan satuan kerja daerah.</li></ul>',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Program Kerja',
                'slug' => 'program-kerja',
                'excerpt' => 'Bidang kegiatan utama yang dijalankan organisasi.',
                'content' => '<p>Program kerja Dharmayukti Karini Cabang Papua Barat diarahkan pada kegiatan yang memperkuat peran organisasi di bidang sosial, pendidikan, kesehatan, dan ekonomi kreatif.</p><ul><li><strong>Bidang Sosial</strong>: bakti sosial, kunjungan ke panti asuhan, bantuan bencana alam, dan kegiatan amal lainnya.</li><li><strong>Bidang Pendidikan</strong>: program beasiswa, pelatihan keterampilan, seminar, dan workshop untuk anggota.</li><li><strong>Bidang Kesehatan</strong>: pemeriksaan kesehatan gratis, senam bersama, dan penyuluhan kesehatan masyarakat.</li><li><strong>Bidang Ekonomi Kreatif</strong>: pelatihan kewirausahaan, pameran produk UMKM, dan pemberdayaan ekonomi anggota.</li></ul>',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('profile_pages');
    }
}
