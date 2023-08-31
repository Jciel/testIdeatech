<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = ['title', 'gender', 'synopsis', 'cover', 'publicationYear', 'author_id'];

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'Uuid';

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
