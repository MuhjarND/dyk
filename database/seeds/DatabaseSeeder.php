<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Users
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@dyk.or.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $author = User::create([
            'name' => 'Penulis DYK',
            'email' => 'penulis@dyk.or.id',
            'password' => Hash::make('author123'),
            'role' => 'author',
        ]);

        // Categories
        $categories = [
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'description' => 'Berita seputar kegiatan organisasi'],
            ['name' => 'Sosial', 'slug' => 'sosial', 'description' => 'Kegiatan sosial dan kemasyarakatan'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Program pendidikan dan pelatihan'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'description' => 'Program kesehatan dan kesejahteraan'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Pengumuman resmi organisasi'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Sample Posts
        $posts = [
            [
                'title' => 'Bakti Sosial Dharmayukti Karini di Desa Sukamaju',
                'slug' => 'bakti-sosial-dharmayukti-karini-di-desa-sukamaju',
                'excerpt' => 'Dharmayukti Karini menggelar kegiatan bakti sosial berupa pembagian sembako dan pemeriksaan kesehatan gratis bagi masyarakat.',
                'content' => '<p>Dharmayukti Karini menggelar kegiatan bakti sosial di Desa Sukamaju pada hari Sabtu, 15 Maret 2026. Kegiatan ini diikuti oleh seluruh anggota pengurus cabang yang turut memberikan bantuan sembako kepada masyarakat yang membutuhkan.</p><p>Selain pembagian sembako, juga diadakan pemeriksaan kesehatan gratis bekerjasama dengan Puskesmas setempat. Sebanyak 200 warga mendapatkan layanan pemeriksaan kesehatan secara cuma-cuma.</p><p>Ketua Dharmayukti Karini Cabang menyampaikan bahwa kegiatan ini merupakan wujud kepedulian organisasi terhadap masyarakat sekitar, sekaligus sebagai bentuk pengabdian istri-istri pegawai Kejaksaan kepada bangsa dan negara.</p>',
                'category_id' => 2, 'author_id' => $admin->id, 'status' => 'published', 'views' => 120,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Pelatihan Kewirausahaan untuk Anggota Dharmayukti Karini',
                'slug' => 'pelatihan-kewirausahaan-untuk-anggota',
                'excerpt' => 'Program pelatihan kewirausahaan guna meningkatkan kemandirian ekonomi anggota Dharmayukti Karini.',
                'content' => '<p>Dalam rangka meningkatkan kemandirian ekonomi anggota, Dharmayukti Karini menyelenggarakan pelatihan kewirausahaan yang diikuti oleh 50 peserta dari berbagai cabang.</p><p>Pelatihan ini menghadirkan narasumber dari kalangan pengusaha sukses yang berbagi pengalaman dan tips memulai usaha rumahan. Materi yang disampaikan meliputi pembuatan produk UMKM, pemasaran digital, serta pengelolaan keuangan usaha kecil.</p><p>Para peserta sangat antusias mengikuti pelatihan ini dan berharap dapat mengimplementasikan ilmu yang didapat untuk meningkatkan perekonomian keluarga.</p>',
                'category_id' => 3, 'author_id' => $admin->id, 'status' => 'published', 'views' => 89,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Peringatan Hari Jadi Dharmayukti Karini ke-27',
                'slug' => 'peringatan-hari-jadi-dharmayukti-karini-ke-27',
                'excerpt' => 'Perayaan HUT ke-27 Dharmayukti Karini digelar secara meriah dengan berbagai rangkaian acara menarik.',
                'content' => '<p>Dharmayukti Karini memperingati Hari Jadi ke-27 dengan menggelar serangkaian acara yang berlangsung selama satu minggu. Acara puncak dilaksanakan di Aula Kejaksaan Agung dengan dihadiri oleh seluruh pengurus pusat dan perwakilan dari cabang-cabang di seluruh Indonesia.</p><p>Rangkaian acara meliputi lomba-lomba, seminar kesehatan, pameran hasil karya anggota, serta acara penganugerahan bagi anggota berprestasi. Puncak perayaan ditutup dengan penampilan seni budaya dari berbagai daerah.</p><p>Ketua Umum Dharmayukti Karini dalam sambutannya mengajak seluruh anggota untuk terus berkarya dan berbakti bagi masyarakat.</p>',
                'category_id' => 1, 'author_id' => $admin->id, 'status' => 'published', 'views' => 245,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Program Beasiswa Pendidikan Anak Pegawai Kejaksaan',
                'slug' => 'program-beasiswa-pendidikan-anak-pegawai',
                'excerpt' => 'Dharmayukti Karini meluncurkan program beasiswa pendidikan untuk anak-anak pegawai Kejaksaan berprestasi.',
                'content' => '<p>Sebagai bentuk kepedulian terhadap pendidikan generasi muda, Dharmayukti Karini meluncurkan program beasiswa pendidikan bagi anak-anak pegawai Kejaksaan yang berprestasi di bidang akademik maupun non-akademik.</p><p>Program beasiswa ini mencakup bantuan biaya pendidikan mulai dari tingkat SD hingga perguruan tinggi. Pada tahap awal, sebanyak 100 anak telah terpilih sebagai penerima beasiswa berdasarkan seleksi yang ketat.</p><p>Program ini diharapkan dapat memotivasi anak-anak pegawai Kejaksaan untuk terus berprestasi dan menjadi kebanggaan keluarga serta organisasi.</p>',
                'category_id' => 3, 'author_id' => $author->id, 'status' => 'published', 'views' => 178,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Senam Sehat Bersama dalam Rangka Hari Kartini',
                'slug' => 'senam-sehat-bersama-hari-kartini',
                'excerpt' => 'Dharmayukti Karini mengadakan senam sehat bersama memperingati Hari Kartini dengan penuh semangat.',
                'content' => '<p>Memperingati Hari Kartini, Dharmayukti Karini mengadakan kegiatan senam sehat bersama yang diikuti oleh ratusan anggota. Kegiatan ini bertujuan untuk mempererat silaturahmi sekaligus menjaga kesehatan para anggota.</p><p>Acara senam sehat ini dilanjutkan dengan berbagai kegiatan menarik lainnya seperti lomba memasak, lomba fashion show busana kebaya, dan penampilan tari tradisional. Para peserta tampak sangat antusias dan gembira mengikuti seluruh rangkaian acara.</p>',
                'category_id' => 4, 'author_id' => $author->id, 'status' => 'published', 'views' => 156,
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Kunjungan Sosial ke Panti Asuhan Harapan Bangsa',
                'slug' => 'kunjungan-sosial-panti-asuhan-harapan-bangsa',
                'excerpt' => 'Dharmayukti Karini melakukan kunjungan sosial dan memberikan bantuan ke Panti Asuhan Harapan Bangsa.',
                'content' => '<p>Dharmayukti Karini melaksanakan kunjungan sosial ke Panti Asuhan Harapan Bangsa sebagai wujud kepedulian organisasi terhadap anak-anak yang membutuhkan perhatian dan kasih sayang.</p><p>Dalam kunjungan ini, pengurus Dharmayukti Karini memberikan bantuan berupa perlengkapan sekolah, bahan makanan, dan pakaian layak pakai. Selain itu, para anggota juga mengadakan kegiatan bermain dan belajar bersama anak-anak panti.</p><p>Ketua Dharmayukti Karini menyampaikan bahwa kegiatan sosial seperti ini akan terus dilakukan secara rutin sebagai bagian dari program kerja organisasi.</p>',
                'category_id' => 2, 'author_id' => $admin->id, 'status' => 'published', 'views' => 98,
                'published_at' => now()->subDays(18),
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
