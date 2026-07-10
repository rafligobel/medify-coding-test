<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\KategoriItem;

class MasterItem extends Model
{
    use HasFactory, SoftDeletes;

    public function kategoris()
    {
        return $this->belongsToMany(KategoriItem::class, 'kategori_item_master_item');
    }
}
