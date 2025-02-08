<?php

use App\Generators\FilenameGenerator;

uses(Tests\TestCase::class);


describe('FilenameGenerator', function () {
    it('generates a unique filename with all parameters', function () {
        $extension = 'jpg';
        $filename = 'testfile';
        $prefix = 'prefix';
        $suffix = 'suffix';

        $result = FilenameGenerator::generate($extension, $filename, $prefix, $suffix);

        expect($result)->toContain($extension);
        expect($result)->toContain($filename);
        expect($result)->toContain($prefix);
        expect($result)->toContain($suffix);
    });

    it('generates a unique filename with only the extension', function () {
        $extension = 'png';

        $result = FilenameGenerator::generate($extension);

        expect($result)->toContain($extension);
    });

    it('generates a unique filename with filename and extension', function () {
        $extension = 'pdf';
        $filename = 'report';

        $result = FilenameGenerator::generate($extension, $filename);

        expect($result)->toContain($extension);
        expect($result)->toContain($filename);
    });

    it('generates a unique filename with prefix and extension', function () {
        $extension = 'txt';
        $prefix = 'log';

        $result = FilenameGenerator::generate($extension, null, $prefix);

        expect($result)->toContain($extension);
        expect($result)->toContain($prefix);
    });

    it('generates a unique filename with suffix and extension', function () {
        $extension = 'docx';
        $suffix = 'final';

        $result = FilenameGenerator::generate($extension, null, null, $suffix);

        expect($result)->toContain($extension);
        expect($result)->toContain($suffix);
    });

    it('throws an exception if the extension is empty', function () {
        expect(fn () => FilenameGenerator::generate(''))
            ->toThrow(InvalidArgumentException::class, 'File extension cannot be empty.');
    });

    it('correctly handles null prefix and suffix', function () {\n        $extension = 'jpeg';\n        $filename = 'image';\n        $result = FilenameGenerator::generate($extension, $filename, null, null);\n        expect($result)->toContain($extension);\n        expect($result)->toContain($filename);\n    });

    it('ensures the generated filename is urlencoded', function () {
        $extension = 'svg';
        $filename = 'file with spaces';
        $result = FilenameGenerator::generate($extension, $filename);

        expect($result)->toBe(urlencode(urldecode($result)));
    });
});
