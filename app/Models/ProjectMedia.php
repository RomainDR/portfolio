<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['project_id', 'file_path', 'file_type'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
