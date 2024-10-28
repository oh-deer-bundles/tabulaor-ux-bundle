<?php

namespace Odb\TabulatorUxBundle\Model;

class Tabulator
{
    private ?array $data = [];
    private ?array $options = [];
    private ?array $attributes = [];

    public function getDataController(): ?string
    {
        return $this->attributes['data-controller'] ?? null;
    }

    public function createView(): array
    {
        if(!array_key_exists('data', $this->options)) {
                $this->options['data'] = $this->data;
        }
        return $this->options;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): static
    {
        $this->options = $options;
        return $this;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function setAttributes(?array $attributes): static
    {
        $this->attributes = $attributes;
        return $this;
    }


}