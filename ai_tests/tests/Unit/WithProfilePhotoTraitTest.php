<?php

use App\Services\Internal\User\GetProfilePhotoUrlService;
use App\Traits\LivewireTraits\WithProfilePhotoTrait;
use Livewire\Livewire;
use PHPUnit\Framework\TestCase;


class WithProfilePhotoTraitTest extends TestCase
{\    
    public function test_getUserProfilePhotoUrl_calls_GetProfilePhotoUrlService()
    {
        // Create a mock trait implementation
        $mockTrait = new class {
            use WithProfilePhotoTrait;
        };

        // Mock the GetProfilePhotoUrlService
        $mockServiceResult = 'mocked_url';
        
        
        GetProfilePhotoUrlService::shouldReceive('handle')
            ->once()
            ->with('path', 'username', 'firstname')
            ->andReturn($mockServiceResult);

        // Call the method with some test data
        $result = $mockTrait->getUserProfilePhotoUrl('path', 'username', 'firstname');

        // Assert that the service was called and the result is correct
        $this->assertEquals($mockServiceResult, $result);
    }

    public function test_getUserProfilePhotoUrl_returns_default_url_when_service_returns_null()
    {
        // Create a mock trait implementation
        $mockTrait = new class {
            use WithProfilePhotoTrait;
        };

        // Mock the GetProfilePhotoUrlService to return null
        GetProfilePhotoUrlService::shouldReceive('handle')
            ->once()
            ->with(null, 'username', 'firstname')
            ->andReturn(null);

        // Call the method with some test data
        $result = $mockTrait->getUserProfilePhotoUrl(null, 'username', 'firstname');

        // Assert that the result is an empty string when the service returns null
        $this->assertEquals('', $result);
    }

}