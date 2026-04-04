<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Siswa;
use App\Models\TagihanSiswa;

class TahunAjar extends Model
{
    use HasFactory;
    
    protected $table = 'tahun_ajar';

    protected $fillable = [
        'tahun',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function tagihanSiswa()
    {
        return $this->hasMany(TagihanSiswa::class);
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE TAGIHAN OTOMATIS
    |--------------------------------------------------------------------------
    */

    public function generateTagihan()
    {
        $semesterList = ['ganjil','genap'];

        Siswa::chunk(100,function($siswaList) use ($semesterList){

            foreach($siswaList as $siswa){

                foreach($semesterList as $semester){

                    TagihanSiswa::firstOrCreate([
                        'siswa_id'=>$siswa->id,
                        'tahun_ajar_id'=>$this->id,
                        'semester'=>$semester
                    ],[
                        'nominal_tagihan'=>600000,
                        'total_tagihan'=>600000
                    ]);

                }

            }

        });

    }
}