<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterItem;

class KategoriItem extends Model
{
    use HasFactory;

    protected $table = 'kategori_items';
    protected $fillable = ['kode', 'nama'];

    // Relasi Many-to-Many ke MasterItem (Inverse)
    public function masterItems()
    {
        return $this->belongsToMany(MasterItem::class, 'kategori_item_master_item');
    }
}
