<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use Sluggable ;

    protected $fillable = [
        'status',
        'finish_time',
        'link',
        'image',
        'slug',
        'content',
        'name',
        'tags',
        'category_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
    protected $casts = [

        'tags' => 'array',
    ];
}
