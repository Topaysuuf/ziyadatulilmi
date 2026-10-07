<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profil;
use App\Models\Pengumuman;
use App\Models\Siswa;

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Profil Resmi Sekolah / Yayasan
        Profil::create([
            'nama_yayasan' => 'SMA ZIYADATUL ILMI',
            'pimpinan'      => 'KH. Zainuri Yasmin, S.Ag. M.Pd.',
            'nsp'           => '510036730333',
            'alamat'        => 'Link. Nancang Wetan RT.004 RW.004, Kel. Karundang, Kec. Cipocok Jaya, Kota Serang, Banten',
            'no_wa'         => '081389554994',
            'visi'          => 'Menjadi lembaga pendidikan Islam unggulan yang melahirkan generasi beriman, bertakwa, berprestasi, dan berwawasan global.',
            'misi'          => '1. Menyelenggarakan pendidikan berbasis Al-Qur\'an dan Sunnah. 2. Mengembangkan potensi akademik dan non-akademik siswa. 3. Membina karakter kepemimpinan dan kemandirian.',
        ]);

        // 2. Data Pengumuman Awal
        Pengumuman::create([
            'judul'    => 'Pembukaan Penerimaan Santri/Siswa Baru (SPMB) 2026/2027',
            'kategori' => 'SPMB',
            'isi'      => 'Pendaftaran santri/siswa baru SMA Ziyadatul Ilmi resmi dibuka untuk gelombang pertama. Silakan mengisi formulir pendaftaran online.',
            'tanggal'  => '2026-10-07',
        ]);

        Pengumuman::create([
            'judul'    => 'Kegiatan Kajian Kitab Kuning & Pelatihan Tahfidz',
            'kategori' => 'Kegiatan',
            'isi'      => 'Rangkaian ujian tahfidz hafalan Juz 30 dan kajian rutin mingguan akan dilaksanakan di komplek madrasah.',
            'tanggal'  => '2026-10-01',
        ]);

        // 3. Daftar Peserta Didik Terkelompokkan per Kelas & Terurut Abjad (A-Z)
        $daftarSiswa = [

            // ==================== SMA - Kelas 10 ====================
            ['nisn' => '0108546386', 'nama' => 'AMALIATUS SOLIHAH', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0113808571', 'nama' => 'ANISA AZQIYATUL AFIYAH', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0104156189', 'nama' => 'ARDY TATA WIDJAYA', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0104440891', 'nama' => 'Agha Afkar Khumaeni', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0101794032', 'nama' => 'BATRISYIA SHAZFA KOSEPA', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0114229939', 'nama' => 'FIVRIANSIH', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0116867469', 'nama' => 'IBNU MAHDI', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0119531953', 'nama' => 'KHOIRUL\'AZAM', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '3118412144', 'nama' => 'MAULANA HASAN', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0117805188', 'nama' => 'MUHAMAD DIAVI NURIL QO\'IIS', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '3118203189', 'nama' => 'MUHAMAD RAFFA FACHRUZI', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0117015555', 'nama' => 'MUHAMAD ZAKIYATUL MUSTOPA ALFIKRI', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '3103730577', 'nama' => 'MUHAMMAD FADHIL MAKARIM', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0118206442', 'nama' => 'MUHAMMAD HAFIIDH', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '3114352068', 'nama' => 'MUHAMMAD KHAIRUL AZZAM', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0103986127', 'nama' => 'Muhammad Alif', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0117910009', 'nama' => 'Muhammad Subhan Maulidi', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '3114948663', 'nama' => 'RAFFASYA ATHARRAYHAN KIANO', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0104417619', 'nama' => 'RAHMA DZAKIYYAH', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0112976063', 'nama' => 'SITI MIFTAHUL JANNAH', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0104446718', 'nama' => 'WISNU', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '0106479520', 'nama' => 'ZASKIA ASYA SYAKHIRA', 'kelas' => 'SMA - Kelas 10'],
            ['nisn' => '3113441899', 'nama' => 'ZIDNI ALFA RIZKI', 'kelas' => 'SMA - Kelas 10'],

            // ==================== SMA - Kelas 11 ====================
            ['nisn' => '0105840794', 'nama' => 'ANAM ABDILLAH AL AMIEN', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0102503974', 'nama' => 'ANDREAN SETIAWAN', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0105754544', 'nama' => 'ANJANI KHOIRUNISA', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0101822488', 'nama' => 'Aura Octavlaniya', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0095071054', 'nama' => 'DEBER GALUH ADRIAN', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0101844658', 'nama' => 'DINAH LATIFAH AINI', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0106347431', 'nama' => 'HANDOYO NDARU PRASETYO', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0104170109', 'nama' => 'MUHAMMAD AZZAM', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0109926539', 'nama' => 'SYIFFA FEBYANI AZZAHRA', 'kelas' => 'SMA - Kelas 11'],
            ['nisn' => '0105313431', 'nama' => 'Tsabitah Putri Nailah', 'kelas' => 'SMA - Kelas 11'],

            // ==================== SMA - Kelas 12 ====================
            ['nisn' => '0093312825', 'nama' => 'DICKY PERMANA', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0091914090', 'nama' => 'Dzussabili Azizi Kosepa', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0094615788', 'nama' => 'Habib El Mustofa', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0089978762', 'nama' => 'M. ANDREW ALFARIZI', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '3097204913', 'nama' => 'MUHAMMAD AFDAL GUNAWAN', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0097112811', 'nama' => 'MUHAMMAD FADILLAH AL-QUDHSY', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0093170449', 'nama' => 'MUHAMMAD GAZA MUBARAK', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0082449127', 'nama' => 'MUTHIA ANNISA', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0086486821', 'nama' => 'NAZLA GIYAS RAMADHAN', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0097156652', 'nama' => 'SYARIF HIDAYAT', 'kelas' => 'SMA - Kelas 12'],
            ['nisn' => '0083609934', 'nama' => 'VEBY TESYE VALENTIN', 'kelas' => 'SMA - Kelas 12'],

            // ==================== SMP - Kelas 7 ====================
            ['nisn' => '3132611866', 'nama' => 'ABRAR ATHALLA RIAZ', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0132803975', 'nama' => 'Ahmad Alfian Rizqie', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3143387563', 'nama' => 'ALYA JAZILAH SETIAWAN', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0139561916', 'nama' => 'ASYAM HADI FAUZAN', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0131337548', 'nama' => 'AYESHA RAYA RABBANI', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0136362143', 'nama' => 'AYU MULYANA SARI', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3134078797', 'nama' => 'DAFFA ARDIYANTO', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3136270575', 'nama' => 'DEREN ARDIAN', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3147771721', 'nama' => 'EVA AS-SYIFA', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0131534974', 'nama' => 'FAIZ FAADIHILAH', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0131007270', 'nama' => 'FIKRI FIRJATULLAH RAMADHAN', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3138039203', 'nama' => 'GEA OKTAVIA FADLI', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3149717046', 'nama' => 'KHASIFAHTUS SAJA', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3148738286', 'nama' => 'MUHAMAD ADNAN FAISHAL ALGHIFARI', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0149988063', 'nama' => 'MUHAMAD AL-FATIH', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3146547514', 'nama' => 'MUHAMAD BUSTANUL ARIFIN', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3141787485', 'nama' => 'MUHAMMAD AR RASID', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0143824896', 'nama' => 'MUHAMMAD FADLIANSYAH', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0141732927', 'nama' => 'MUHAMMAD UWAIS RUZAINSYAH', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3142470957', 'nama' => 'Muhammad Naufal Afkar', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3148330159', 'nama' => 'NAHDIYAH', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0132306582', 'nama' => 'Nur Azzahra Hafidzah El Muharom', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0146909417', 'nama' => 'Nurul Yuliazahra', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3134434135', 'nama' => 'Qurratu\'aini Pawoko Putri', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0128749397', 'nama' => 'Siti Halimatu ssya\'diyah', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '0139972841', 'nama' => 'Siti Mariyatu Qibtiyah', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3145362780', 'nama' => 'SUKAINAH ZAKIYYAH', 'kelas' => 'SMP - Kelas 7'],
            ['nisn' => '3130427901', 'nama' => 'SULTHAN RAZHAN GUNADI', 'kelas' => 'SMP - Kelas 7'],

            // ==================== SMP - Kelas 8 ====================
            ['nisn' => '3121087941', 'nama' => 'AINAYYA JIHAN SYAFIRA', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3135917858', 'nama' => 'AIRIN PUTRI ZATULINI', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3139179220', 'nama' => 'Alya Nasywa', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0135422070', 'nama' => 'Azkia Salsabila Maheswari', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3128055373', 'nama' => 'DAFFA SYAWALUDIN', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0135407382', 'nama' => 'FAIDA ANNAILA', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3124265373', 'nama' => 'FATHIR ALISAPUTRA', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0102547002', 'nama' => 'Fira Aulia', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3133917981', 'nama' => 'FITRI HUMAIROH', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3123132602', 'nama' => 'HAFIZ ZULPI', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3121580188', 'nama' => 'HILMA ADSYILA', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3133086836', 'nama' => 'MAHIRA HASNA MAULIDA', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3121376666', 'nama' => 'Muhamad Farand', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3123759816', 'nama' => 'Muhammad Al Fatih Saputra', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3128221602', 'nama' => 'Muhammad Azizan Arif Afari', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3137292645', 'nama' => 'MUHAMMAD ILHAM ALIYUDIN', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3120958951', 'nama' => 'MUHAMMAD RAYQI SUBHAN', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0127768152', 'nama' => 'MUHAMMAD RESTU', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3139057385', 'nama' => 'MUHAMMAD SEM EL MUIZ', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0139070503', 'nama' => 'NABIL SYAFIQ MUYASSAR', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0122054619', 'nama' => 'OLINDA TRI KUMALA', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3132223405', 'nama' => 'Popy Windy Astuty', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3129973807', 'nama' => 'PRISYILA NABILATUL MUFTIAH', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3123115357', 'nama' => 'RAFA NURUN IBENG', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3138041699', 'nama' => 'RAFFA SAPUTRA', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0129961826', 'nama' => 'SITI AYU RAHMA YANTI', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0122470704', 'nama' => 'SITI NURANNISA', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '0126770078', 'nama' => 'Siti Robiah Chantika', 'kelas' => 'SMP - Kelas 8'],
            ['nisn' => '3139386923', 'nama' => 'ZAHRA APRILIA', 'kelas' => 'SMP - Kelas 8'],

            // ==================== SMP - Kelas 9 ====================
            ['nisn' => '0113034124', 'nama' => 'AHMAD ABNI AL - AHLAMI', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3118211178', 'nama' => 'AUREL HANA TASYA', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3127593426', 'nama' => 'BALQIS ALLYA FEBRIANI GRIAPON', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0111198672', 'nama' => 'Dafa Ramadhan', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0128774877', 'nama' => 'Daffa Bayin Mahdi', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0127921833', 'nama' => 'KHALIF HAKIM ATHARIZZ', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0124098643', 'nama' => 'Kirana Cahya Anggraeni', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3128769379', 'nama' => 'LUVITA NADIRA PUTRI', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0121771272', 'nama' => 'Muhamad Khoirul Hakim', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0128451834', 'nama' => 'MUHAMAD YUSUP', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3114180929', 'nama' => 'MUHAMMAD KAISAR RIZKI', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3110718108', 'nama' => 'NOPI RISMAWATI', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0124976334', 'nama' => 'Nur Az - Zukhruf Hilal Ramadhania', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3127268573', 'nama' => 'PUTRA SAI`AN PRATAMA', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3126045718', 'nama' => 'RAIHAN NAFIS', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0112888562', 'nama' => 'Rendra Dwi Kurniawan', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0129347645', 'nama' => 'Rizqi Rhamadan', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0125429331', 'nama' => 'SAPTIAN', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3121507675', 'nama' => 'Silvia Putri', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3122389243', 'nama' => 'STEPHANIE GONDHODISASTRO', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0114548845', 'nama' => 'SULKI', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3112096036', 'nama' => 'SYIFA KHOIRUNNISA', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '3122000284', 'nama' => 'VINO SANDIKA', 'kelas' => 'SMP - Kelas 9'],
            ['nisn' => '0121133181', 'nama' => 'Yuga Solehudin', 'kelas' => 'SMP - Kelas 9']
        ];

        foreach ($daftarSiswa as $data) {
            Siswa::create($data);
        }
    }
}