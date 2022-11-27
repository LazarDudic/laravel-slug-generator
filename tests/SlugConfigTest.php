<?php

namespace Dudic\Sluggable\Tests;

use Dudic\Sluggable\Exceptions\SlugGeneratorException;
use Dudic\Sluggable\SlugConfig;

class SlugConfigTest extends TestCase
{
    public function testMinimumFieldRequirementPass(): void
    {
        $slugConfig = SlugConfig::set([
            'create_from' => ['title'],
            'slug_field' => 'slug',
        ]);

        $this->assertInstanceOf(SlugConfig::class, $slugConfig);
    }

    public function testCreateSlugFromRequired(): void
    {
        $this->expectException(SlugGeneratorException::class);
        SlugConfig::set(['slug_field' => 'slug']);
    }

    public function testSlugFieldRequired(): void
    {
        $this->expectException(SlugGeneratorException::class);
        SlugConfig::set(['create_from' => ['title']]);
    }

    public function testMaxLenghtMinimumOne(): void
    {
        $this->expectException(SlugGeneratorException::class);
        SlugConfig::set([
            'create_from' => ['title'],
            'slug_field' => 'slug',
            'max_length' => 0,
        ]);
    }
}
