<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_done',
        'project_id'
    ];
    protected $casts=[
        'is_done' => 'boolean'
    ];

    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class,'creator_id');
    }

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    protected static function booted()
    {
        static::addGlobalScope('creator',function (Builder $builder){
           $builder->where('creator_id',Auth::id());

        });

    }

    public function scopeFinished(Builder $query)
    {
        $query->where('is_done',true); // to get it you can make : Task::finished()->get()
    }
}
