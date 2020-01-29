<?php

namespace Skorp\Dissua;

/**
 * Class SameSite
 * @package Skorp\Dissua
 * @url https://github.com/skorp/detect-incompatible-samesite-useragents
 */
class SameSite {

    protected $userAgent = null;

    public function __construct($userAgent) {
        $this->userAgent = $userAgent;
    }


    public static function handle(string $userAgent = null) : bool {
        return (new self($userAgent))->shouldSendSameSiteNone();
    }


    public function shouldSendSameSiteNone() : bool {
        return !$this->isSameSiteNoneIncompatible();
    }


    protected function isSameSiteNoneIncompatible() : bool {
        return $this->hasWebKitSameSiteBug() || $this->dropsUnrecognizedSameSiteCookies();
    }


    protected function hasWebKitSameSiteBug() : bool {
        return $this->isIosVersion(12) ||
            ($this->isMacosxVersion(10, 14) &&
                ($this->isSafari() || $this->isMacEmbeddedBrowser()));
    }


    protected function dropsUnrecognizedSameSiteCookies() : bool {
        if ($this->isUcBrowser())
            return !$this->isUcBrowserVersionAtLeast(12, 13, 2);

        return  $this->isChromiumBased() &&
            $this->isChromiumVersionAtLeast(51) &&
            !$this->isChromiumVersionAtLeast(67);
    }


    protected function isChromiumBased() : bool  {
        $regex = '/Chrom(e|ium)/';
        return preg_match($regex,$this->userAgent);
    }


    protected function isChromiumVersionAtLeast($version)  : bool {
        $regex = '/Chrom[^ \/]+\/(\d+)[\.\d]*/';
        preg_match($regex,$this->userAgent,$matches);
        return ($matches[1]??null) >= $version;
    }


    protected function isIosVersion($major) : bool {
        $regex = "/\(iP.+; CPU .*OS (\d+)[_\d]*.*\) AppleWebKit\//";
        preg_match($regex,$this->userAgent,$matches);
        return ($matches[1]??null) == $major;
    }


    protected function isMacosxVersion($major,$minor) : bool {
        $regex = "/\(Macintosh;.*Mac OS X (\d+)_(\d+)[_\d]*.*\) AppleWebKit\//";
        preg_match($regex,$this->userAgent,$matches);

        return (($matches[1]??null) == $major   && (($matches[2]??null) == $minor));
    }


    protected function isSafari() : bool {
        $regex = "/Version\/.* Safari\//";
        return preg_match($regex,$this->userAgent) && ! $this->isChromiumBased();
    }


    protected function isMacEmbeddedBrowser() : bool {
        $regex = "#/^Mozilla\/[\.\d]+ \(Macintosh;.*Mac OS X [_\d]+\) AppleWebKit\/[\.\d]+ \(KHTML, like Gecko\)$#";
        return preg_match($regex,$this->userAgent);
    }


    protected function isUcBrowser()  : bool {
        $regex = '/UCBrowser\//';
        return preg_match($regex,$this->userAgent);
    }


    protected function isUcBrowserVersionAtLeast($major,$minor,$build) : bool {

        $regex = "/UCBrowser\/(\d+)\.(\d+)\.(\d+)[\.\d]* /";

        preg_match($regex,$this->userAgent,$matches);

        $major_version = $matches[1] ?? null;
        $minor_version = $matches[2] ?? null;
        $build_version = $matches[3] ?? null;

        if ($major_version != $major)
            return $major_version > $major;
        if ($minor_version != $minor)
            return $minor_version > $minor;
        return $build_version >= $build;
    }
}
