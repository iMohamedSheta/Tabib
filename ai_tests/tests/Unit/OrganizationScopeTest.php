<?php

use App\Models\Organization;
use App\Models\Scopes\OrganizationScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


beforeEach(function (): void {
    $this->user = User::factory()->create();
    Auth::setUser($this->user);
    $this->builder = Mockery::mock(Builder::class);
    $this->model = Mockery::mock(Model::class);
    $this->scope = new OrganizationScope();
});

it('applies the scope with organization id', function (): void {
    $this->builder->shouldReceive('where')->with('organization_id', $this->user->organization_id)->once()->andReturnSelf();
    $this->scope->apply($this->builder, $this->model);
});

it('applies the scope with organization id when the model is an organization', function (): void {
    $organization = Organization::factory()->create();
    $this->user->organization_id = $organization->id;
    Auth::setUser($this->user);
    $this->builder = Mockery::mock(Builder::class);
    $this->builder->shouldReceive('where')->with('id', $this->user->organization_id)->once()->andReturnSelf();
    $this->builder->shouldReceive('where')->with('organization_id', $this->user->organization_id)->once()->andReturnSelf();
    $this->scope->apply($this->builder, $organization);
});

