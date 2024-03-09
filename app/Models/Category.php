<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault([
            'name' => 'Danh mục cha',
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('childrenRecursive');
    }

    public function getDescendantNamesAttribute()
    {
        $descendants = collect([$this->id, $this->name]);

        if ($this->relationLoaded('childrenRecursive') && $this->childrenRecursive->isNotEmpty()) {
            foreach ($this->childrenRecursive as $child) {
                $descendants = $descendants->merge($child->descendantNames);
            }
        }

        return $descendants->toArray();
    }
}
