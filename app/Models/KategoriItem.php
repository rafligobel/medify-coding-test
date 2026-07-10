<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriItem extends Model
{
    protected $fillable = ['kode', 'nama'];

    // Relasi many-to-many ke master item
    public function masterItems()
    {
        return $this->belongsToMany(MasterItem::class, 'kategori_item_master_item');
    }
}