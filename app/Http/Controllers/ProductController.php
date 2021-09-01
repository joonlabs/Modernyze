<?php

namespace App\Http\Controllers;

use App\Models\User;
use Curfle\FileSystem\FileSystem;
use Curfle\Hash\Algorithm\HMAC;
use Curfle\Routing\Controller;
use Curfle\Support\Exceptions\Http\HttpDispatchableException;
use Curfle\Support\Facades\Auth;
use Curfle\Support\Facades\File;
use Curfle\Support\Facades\Hash;

class ProductController extends Controller
{

    /**
     * Returns all users.
     *
     * @return array
     */
    public function all(): array
    {
        return File::files(base_path(env("SERVING_DIRECTORY")));
    }

    public function latest($product)
    {
        return [
            "version" => $this->getLatestVersion($product)
        ];
    }

    /**
     * Returns whether a product exists or not.
     *
     * @param string $product
     * @return bool
     */
    private function exists(string $product): bool
    {
        return File::isDirectory(base_path(env("SERVING_DIRECTORY")) . "/$product");
    }

    /**
     * Returns all versions of a product.
     *
     * @param string $product
     * @return array
     * @throws HttpDispatchableException
     */
    public function versions(string $product): array
    {
        if (!$this->exists($product))
            abort(404, "Not found");

        $files = File::files(base_path(env("SERVING_DIRECTORY")) . "/$product");
        $files = array_map(function ($item) {
            return str_replace("v", "", str_replace(".zip", "", $item));
        }, $files);
        usort($files, "version_compare");

        return $files;
    }

    /**
     * Returns information about a given product version.
     *
     * @param string $product
     * @param string $version
     * @return array
     * @throws HttpDispatchableException
     */
    public function version(string $product, string $version): array
    {
        $filePath = base_path(env("SERVING_DIRECTORY")) . "/$product/v$version.zip";
        if (!File::exists($filePath))
            abort(404, "Not found");

        return [
            "url" => url("/api/product/$product/$version/download"),
            "hash" => HMAC::hash(File::get($filePath), Auth::user()->secret)
        ];
    }

    /**
     * Returns the latest available version.
     *
     * @param string $product
     * @return string|null
     * @throws HttpDispatchableException
     */
    private function getLatestVersion(string $product): ?string
    {
        $versions = $this->versions($product);
        return end($versions) ?: null;
    }
}