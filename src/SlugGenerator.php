<?php

declare(strict_types=1);

namespace Dudic\Sluggable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Dudic\Sluggable\Exceptions\SlugGeneratorException;

trait SlugGenerator
{
    protected SlugConfig $slugConfig;

    public static function bootSlugGenerator(): void
    {
        static::creating(function (Model $model) {
            if ($model->slugCanBeGeneratedOn('create')) {
                $model->generateSlug();
            }
        });
        static::updating(function (Model $model) {
            if ($model->slugCanBeGeneratedOn('update')) {
                $model->generateSlug();
            }
        });
    }

    protected function getSlugConfig(): SlugConfig
    {
        if (! property_exists($this, 'slugConfiguration')) {
            throw new SlugGeneratorException('Property $slugConfiguration not found in '.static::class);
        }

        return SlugConfig::set($this->slugConfiguration);
    }

    protected function slugCanBeGeneratedOn(string $observer): bool
    {
        $this->slugConfig = $this->getSlugConfig();
        switch ($observer) {
            case 'create':
                return $this->slugConfig->onCreate;
            case 'update':
                return $this->slugConfig->onUpdate;
            default:
                return false;
        }
    }

    protected function generateSlug(): void
    {
        $slug = $this->getSlugFromFields();
        $slug = $this->withMaxLength($slug);
        if ($this->slugConfig->unique) {
            $slug = $this->makeSlugUnique($slug);
        }
        $this->{$this->slugConfig->slugField} = $slug;
    }

    protected function getSlugFromFields(): string
    {
        $slug = '';
        foreach ($this->slugConfig->createSlugFrom as $field) {
            $slug .= $this->createSlugFromString((string) $this->{$field}).$this->slugConfig->separator;
        }

        if ($countSeparatorCharacters = strlen($this->slugConfig->separator)) {
            $slug = substr($slug, 0, -$countSeparatorCharacters);
        }

        return $slug;
    }

    protected function makeSlugUnique(string $slug): string
    {
        $count = 1;
        while ($this->where($this->slugConfig->slugField, $slug)->exists()) {
            $slug = $slug.$this->slugConfig->separator.$count;
            $count++;
        }

        return $slug;
    }

    protected function withMaxLength(string $slug): string
    {
        if (strlen($slug) > $this->slugConfig->maxLength) {
            $slug = substr($slug, 0, $this->slugConfig->maxLength);
        }

        return $slug;
    }

    protected function createSlugFromString(string $slug): string
    {
        return Str::slug($slug, $this->slugConfig->separator);
    }
}
