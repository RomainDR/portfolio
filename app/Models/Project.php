<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'github_link'
    ];

    public function media()
    {
        return $this->hasMany(ProjectMedia::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
