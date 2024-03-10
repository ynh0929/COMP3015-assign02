<?php

namespace core;

class UploadedFile {
    private array $file;

    public function __construct(array $file) {
        $this->file = $file;
    }

    public function getName(): string {
        return $this->file['name'] ?? '';
    }

    public function getTempName(): string {
        return $this->file['tmp_name'] ?? '';
    }

    public function getType(): string {
        return $this->file['type'] ?? '';
    }
}
