<?php
// src/Twig/AppExtension.php
namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sqrt', [$this, 'squareOperation']),
        ];
    }
    public function squareOperation( float $arg = 0 )
    {
        return sqrt($arg);
    }
}