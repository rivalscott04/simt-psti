<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //seeder prodi
        \App\Models\Prodi::factory()->create([
            'id_prodi' => 'prodi1',
            'nama_prodi' => 'teknik Informatika'
        ]);

        //seeder User
        \App\Models\User::factory()->create([
            'id' => '197311302000031001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Prof. Dr. Eng. I Gede Pasek Suta Wijaya, S.T., M.T.',
            'password' => bcrypt('197311302000031001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '197506122000031001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Heri Wijayanto, S.T., M.T., Ph.D.',
            'password' => bcrypt('197506122000031001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '197005141999031002',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Ida Bagus Ketut Widiartha, S.T., M.T., Ph.D.',
            'password' => bcrypt('197005141999031002')
        ]);

        \App\Models\User::factory()->create([
            'id' => '196604032006042001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Ir. Sri Endang Anjarwani, M.Kom.',
            'password' => bcrypt('196604032006042001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '197210191999032001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Dr. Eng. Budi Irmawati, S.Kom., M.T.',
            'password' => bcrypt('197210191999032001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199012182012121002',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Dr. Ario Yudo Husodo, S.T., M.T.',
            'password' => bcrypt('199012182012121002')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198211182015041001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'I Wayan Agus Arimbawa, S.T., M.Eng.',
            'password' => bcrypt('198211182015041001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198609132015041001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Ariyan Zubaidi, S.Kom., M.T.',
            'password' => bcrypt('198609132015041001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198606222015041002',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Fitri Bimantoro, S.T., M.Kom.',
            'password' => bcrypt('198606222015041002')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198312092012121001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Andy Hidayat Jatmika, S.T., M.Kom.',
            'password' => bcrypt('198312092012121001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198311252015041002',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Moh. Ali Albar, S.T., M.Eng.',
            'password' => bcrypt('198311252015041002')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198608132018032001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Nadiyasari Agitha, S.Kom., M.M.T.',
            'password' => bcrypt('198608132018032001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198507072014042001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Royana Afwani, S.T., M.T.',
            'password' => bcrypt('198507072014042001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199005052020121017',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Noor Alamsyah, S.T., M.T.',
            'password' => bcrypt('199005052020121017')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199001142019031018',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Ari Hernawan, S.Kom., M.Sc.',
            'password' => bcrypt('199001142019031018')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198902052022031005',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Raphael Bianco Huwae, S.T., M.T.',
            'password' => bcrypt('198902052022031005')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198409192018031001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Dr. Eng. Wirarama Wedashwara, S.T., M.T.',
            'password' => bcrypt('198409192018031001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199402202019031004',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Arik Aranta, S.Kom., M.Kom.',
            'password' => bcrypt('199402202019031004')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199203232019031012',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Gibran Satya Nugraha, S.Kom., M.Eng.',
            'password' => bcrypt('199203232019031012')
        ]);

        \App\Models\User::factory()->create([
            'id' => 'Ahmad123',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Ahmad Zafrullah Mardiansyah, S.T., M.Eng.',
            'password' => bcrypt('Ahmad123')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198910192022031007',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Ramaditia Dwiyansaputra, S.T., M.Eng.',
            'password' => bcrypt('198910192022031007')
        ]);

        \App\Models\User::factory()->create([
            'id' => '196810281998021001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Cahyo Mustiko Okta Muvianto, S.T., M.Sc., Ph.D.',
            'password' => bcrypt('196810281998021001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198509012019032010',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Dwi Ratnasari, S.Kom., M.T.',
            'password' => bcrypt('198509012019032010')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199404192023212037',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Santi Ika Murpratiwi, S.Kom., M.T.',
            'password' => bcrypt('199404192023212037')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198512312011011012',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Halil Akhyar, S.T., MInfTech.',
            'password' => bcrypt('198512312011011012')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199406102024061001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Mohammad Zaenuddin Hamidi, S.T., M.Kom.',
            'password' => bcrypt('199406102024061001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199008252024061001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Pahrul Irfan, S.Kom., M.Kom.',
            'password' => bcrypt('199008252024061001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '199509272024062004',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Regania Pasca Rassy, S.Kom., M.IM.',
            'password' => bcrypt('199509272024062004')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198402272024212016',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Herliana Rosika, S.Kom., M.Kom.',
            'password' => bcrypt('198402272024212016')
        ]);

        //Staf
        \App\Models\User::factory()->create([
            'id' => '197902242005011001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Azwar Faridi, S.T.',
            'password' => bcrypt('197902242005011001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '197902242005011001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Azwar Faridi, S.T.',
            'password' => bcrypt('197902242005011001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '198207182008102001',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Baiq Eny Mariana, S.E.',
            'password' => bcrypt('198207182008102001')
        ]);

        \App\Models\User::factory()->create([
            'id' => '20191996041030',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Rival Biasrori, S.Kom.',
            'password' => bcrypt('20191996041030')
        ]);

        \App\Models\User::factory()->create([
            'id' => 'Ikhwan123',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Lalu Ikhwan Rosadi, S.Kom.',
            'password' => bcrypt('Ikhwan123')
        ]);

        \App\Models\User::factory()->create([
            'id' => 'Ragil123',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Ragil Galuh Pangita S.Kom.',
            'password' => bcrypt('Ragil123')
        ]);

        \App\Models\User::factory()->create([
            'id' => 'Reza123',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Reza Rismawandi, S.Kom.',
            'password' => bcrypt('Reza123')
        ]);

        \App\Models\User::factory()->create([
            'id' => '2012198708290',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Azhari Hasbi, S.T.',
            'password' => bcrypt('2012198708290')
        ]);

        \App\Models\User::factory()->create([
            'id' => 'Baiq123',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Baiq Azizah Tauhida, S.Kom.',
            'password' => bcrypt('Baiq123')
        ]);

        \App\Models\User::factory()->create([
            'id' => 'AdHoc1',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Nama Pengguna AdHoc 1',
            'password' => bcrypt('123')
        ]);
        
        \App\Models\User::factory()->create([
            'id' => 'Admin1',
            'id_prodi' => 'prodi1',
            'nama_pengguna' => 'Nama Pengguna Admin 1',
            'password' => bcrypt('123')
        ]);

        //seeder Role
        \App\Models\Role::factory()->create([
            'id' => '1',
            'name' => 'Kaprodi'
        ]);
        \App\Models\Role::factory()->create([
            'id' => '2',
            'name' => 'Sekprodi'
        ]);
        \App\Models\Role::factory()->create([
            'id' => '3',
            'name' => 'Kalab'
        ]);
        \App\Models\Role::factory()->create([
            'id' => '4',
            'name' => 'AdHoc'
        ]);
        \App\Models\Role::factory()->create([
            'id' => '5',
            'name' => 'Dosen'
        ]);
        \App\Models\Role::factory()->create([
            'id' => '6',
            'name' => 'Staf'
        ]);
        \App\Models\Role::factory()->create([
            'id' => '7',
            'name' => 'Admin'
        ]);

        //seeder role user
        //kaprodi
        \App\Models\RoleUser::factory()->create([
            'user_id' => '197311302000031001',
            'role_id' => '1',
        ]);

        //sekprodi
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198609132015041001',
            'role_id' => '2',
        ]);

        //kalab
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198606222015041002',
            'role_id' => '3',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198409192018031001',
            'role_id' => '3',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '197005141999031002',
            'role_id' => '3',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198608132018032001',
            'role_id' => '3',
        ]);

        //adhoc
        \App\Models\RoleUser::factory()->create([
            'user_id' => '197005141999031002',
            'role_id' => '4',
        ]);

        //dosen
        \App\Models\RoleUser::factory()->create([
            'user_id' => '197311302000031001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '197506122000031001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '197005141999031002',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '196604032006042001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199012182012121002',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198211182015041001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198609132015041001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198606222015041002',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198312092012121001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198311252015041002',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198608132018032001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198507072014042001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199005052020121017',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199001142019031018',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198902052022031005',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198409192018031001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199402202019031004',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199203232019031012',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => 'Ahmad123',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198910192022031007',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '196810281998021001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198509012019032010',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199404192023212037',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198512312011011012',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199406102024061001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199008252024061001',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '199509272024062004',
            'role_id' => '5',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198402272024212016',
            'role_id' => '5',
        ]);

        //staf
        \App\Models\RoleUser::factory()->create([
            'user_id' => '197902242005011001',
            'role_id' => '6',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '198207182008102001',
            'role_id' => '6',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '20191996041030',
            'role_id' => '6',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => 'Ikhwan123',
            'role_id' => '6',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => 'Ragil123',
            'role_id' => '6',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => 'Reza123',
            'role_id' => '6',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => '2012198708290',
            'role_id' => '6',
        ]);
        \App\Models\RoleUser::factory()->create([
            'user_id' => 'Baiq123',
            'role_id' => '6',
        ]);

        //admin
        \App\Models\RoleUser::factory()->create([
            'user_id' => 'Admin1',
            'role_id' => '7',
        ]);
    }
}
