<?php

namespace Dudic\Sluggable\Tests;

use Dudic\Sluggable\Tests\TestClasses\Models\TestModel;

class SlugGeneratorTest extends TestCase
{
    public function testSlugCanBeCreated(): void
    {
        $model = TestModel::create([
            'title' => 'test slug',
        ]);
        $this->assertEquals('test-slug', $model->slug);
    }

    public function testSlugCanBeUpdated(): void
    {
        $model = TestModel::create([
            'title' => 'slug created',
        ]);

        $this->assertEquals('slug-created', $model->slug);
        $model->setSlugConfig('on_update', true);
        $model->title = 'slug updated';
        $model->save();

        $this->assertEquals('slug-updated', $model->slug);
    }

    public function testCreateUniqueSlug(): void
    {
        $testMoldel = TestModel::create([
            'title' => 'test slug',
        ]);

        $model = new TestModel();
        $model->setSlugConfig('unique', true);
        $model->title = 'test slug';
        $model->save();

        $this->assertEquals('test-slug', $testMoldel->slug);
        $this->assertEquals('test-slug-1', $model->slug);
    }

    public function testCreateNotUniqueSlug(): void
    {
        $testMoldel = TestModel::create([
            'title' => 'test slug',
        ]);

        $model = new TestModel();
        $model->setSlugConfig('unique', false);
        $model->title = 'test slug';
        $model->save();

        $this->assertEquals($testMoldel->slug, $model->slug);
    }

    public function testMaxLengh(): void
    {
        $model = new TestModel();
        $model->setSlugConfig('max_length', 5);
        $model->title = '1234567890';
        $model->save();

        $this->assertEquals(5, strlen($model->slug));
    }

    public function testMultipleFieldsForSlug(): void
    {
        $model = new TestModel();
        $model->setSlugConfig('create_from', ['title', 'other_field']);
        $model->title = '12345';
        $model->other_field = '6789';
        $model->save();

        $this->assertEquals('12345-6789', $model->slug);
    }
}
