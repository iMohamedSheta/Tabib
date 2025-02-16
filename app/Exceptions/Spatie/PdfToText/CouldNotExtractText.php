<?php

namespace App\Exceptions\Spatie\PdfToText;

use Symfony\Component\Process\Exception\ProcessFailedException;

class CouldNotExtractText extends ProcessFailedException
{
}
