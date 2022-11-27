<?php

declare(strict_types=1);

namespace Dudic\Sluggable;

use Dudic\Sluggable\Exceptions\SlugGeneratorException;

class SlugConfig
{
    public array $createSlugFrom;

    public string $slugField;

    public bool $onCreate = true;

    public bool $onUpdate = true;

    public bool $unique = true;

    public string $separator = '-';

    public int $maxLength = 250;

    public function __construct(array $data)
    {
        $this->validateConfigData($data);
        $this->createSlugFrom = $data['create_from'];
        $this->slugField = $data['slug_field'];
        $this->onCreate = $data['on_create'] ?? $this->onCreate;
        $this->onUpdate = $data['on_update'] ?? $this->onUpdate;
        $this->unique = $data['unique'] ?? $this->unique;
        $this->separator = $data['separator'] ?? $this->separator;
        $this->maxLength = $data['max_length'] ?? $this->maxLength;
    }

    public static function set(array $data)
    {
        return new static($data);
    }

    private function validateConfigData(array $data)
    {
        if (! isset($data['create_from']) || ! isset($data['slug_field'])) {
            throw new SlugGeneratorException('Fields create_from and slug_field are required.');
        }

        if (isset($data['max_length']) && $data['max_length'] === 0) {
            throw new SlugGeneratorException('The max_length can not be 0.');
        }
    }
}
