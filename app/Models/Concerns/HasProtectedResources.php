<?php

namespace App\Models\Concerns;

use Illuminate\Http\Request;

trait HasProtectedResources
{
    public function initializeHasProtectedResources(): void
    {
        $this->mergeFillable([
            'resource_password',
            'resource_password_hint',
            'shared_resources',
        ]);

        $this->makeHidden([
            'resource_password',
        ]);

        $this->mergeCasts([
            'shared_resources' => 'array',
        ]);
    }

    public function requiresResourcePassword(): bool
    {
        return filled($this->resource_password);
    }

    public function hasSharedResources(): bool
    {
        return is_array($this->shared_resources) && count($this->shared_resources) > 0;
    }

    public function hasAnyShareableResource(): bool
    {
        if ($this->hasSharedResources()) {
            return true;
        }

        return property_exists($this, 'pdf_file') || isset($this->pdf_file)
            ? filled($this->pdf_file ?? null)
            : false;
    }

    public function verifyResourcePassword(string $password): bool
    {
        if (! $this->requiresResourcePassword()) {
            return true;
        }

        return hash_equals((string) $this->resource_password, trim($password));
    }

    public function resourceLockKey(): string
    {
        return strtolower(class_basename($this)).':'.$this->getKey();
    }

    public function resourcePasswordSignature(): string
    {
        return hash('sha256', (string) $this->resource_password);
    }

    public function isResourceUnlocked(?Request $request = null): bool
    {
        if (! $this->requiresResourcePassword()) {
            return true;
        }

        $request ??= request();
        if ($request === null || ! $request->hasSession()) {
            return false;
        }

        $stored = $request->session()->get('unlocked_resources.'.$this->resourceLockKey());

        return is_string($stored) && hash_equals($this->resourcePasswordSignature(), $stored);
    }

    public function unlockResource(?Request $request = null): void
    {
        if (! $this->requiresResourcePassword()) {
            return;
        }

        $request ??= request();
        if ($request !== null && $request->hasSession()) {
            $request->session()->put(
                'unlocked_resources.'.$this->resourceLockKey(),
                $this->resourcePasswordSignature(),
            );
        }
    }
}
