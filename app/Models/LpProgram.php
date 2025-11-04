<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dotlogics\Grapesjs\App\Traits\EditableTrait;
use Dotlogics\Grapesjs\App\Contracts\Editable;

class LpProgram extends Model implements Editable
{
    use EditableTrait;

    protected $table = 'lp_programs';

    protected $fillable = [
        'product_id',
        'nama_halaman',
        'gjs_data',
    ];

    // (opsional) definisikan relasi
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // (opsional) jika ingin template blok spesifik
    public function getTemplatesPath()
    {
        return 'pages_templates';
    }
}
