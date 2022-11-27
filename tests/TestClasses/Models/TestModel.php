<?php

namespace Dudic\Sluggable\Tests\TestClasses\Models;

use Illuminate\Database\Eloquent\Model;
use Dudic\Sluggable\SlugGenerator;

class TestModel extends Model
{
    use SlugGenerator;

    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;

    protected array $slugConfiguration = [
        'create_from' => ['title'],
        'slug_field' => 'slug',
    ];

    public function setSlugConfig($key, $value)
    {
        $this->slugConfiguration[$key] = $value;
    }
}
