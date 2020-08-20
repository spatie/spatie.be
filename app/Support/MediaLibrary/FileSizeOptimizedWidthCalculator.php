<?php

namespace App\Support\MediaLibrary;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\ResponsiveImages\WidthCalculator\FileSizeOptimizedWidthCalculator as BaseFileSizeOptimizedWidthCalculator;
use Spatie\MediaLibrary\Support\ImageFactory;

class FileSizeOptimizedWidthCalculator extends BaseFileSizeOptimizedWidthCalculator
{
    /*
     * The only difference with the base width calculator is a bigger
     * step size resulting in fewer images.
     */
    public float $stepSize = 0.6;

    public function calculateWidths(int $fileSize, int $width, int $height): Collection
    {
        $targetWidths = collect();

        $targetWidths->push($width);

        $ratio = $height / $width;
        $area = $height * $width;

        $predictedFileSize = $fileSize;
        $pixelPrice = $predictedFileSize / $area;

        while (true) {
            $predictedFileSize *= $this->stepSize;

            $newWidth = (int) floor(sqrt(($predictedFileSize / $pixelPrice) / $ratio));

            if ($this->finishedCalculating($predictedFileSize, $newWidth)) {
                return $targetWidths;
            }

            $targetWidths->push($newWidth);
        }
    }
}
