<?php

use Impl\Service\Cache\LaravelCache;
use Illuminate\Support\Collection;
/*
 Integration test with Laravel Cache.
 Testing environment defaults to "array" provider

 This implementation knowingly does not work with
 the file provider, as Laravel's cache does not support
 the  useage of "section" with file-based caching.
 */

class LaravelCacheTest extends TestCase {

    /*
     * Test a NOT set cache key does NOT
     * get reported as existing via `has()`
     * method
     */
    public function testHasMethodHasNoKey()
    {
        $cache = $this->getLaravelCache();

        $randomKey = $this->getRandomString(10);

        $this->assertFalse( $cache->has($randomKey) );
    }

    /*
     * Test a set cache key DOES
     * get reported as existing via `has()`
     * method
     */
    public function testHasMethodHasKey()
    {
        $cache = $this->getLaravelCache();

        $randomKey = $this->getRandomString(10);
        $randomValue = $this->getRandomString(10);

        $cache->put($randomKey, $randomValue);

        $this->assertTrue( $cache->has($randomKey) );
    }

    /*
     * Test that a set value does get set
     */
    public function testPutDoesPutData()
    {
        $cache = $this->getLaravelCache();

        $randomKey = $this->getRandomString(10);
        $randomValue = $this->getRandomString(10);

        $cache->put($randomKey, $randomValue);

        $cachedData = $cache->get($randomKey);

        $this->assertTrue( $cache->has($randomKey) );
        $this->assertEquals( $cachedData, $randomValue );
    }

    /*
     * Test semi-complex paginated data
     * is saved correctly
     */
    public function testPaginatedDataSaved()
    {
        $cache = $this->getLaravelCache();

        $randomKey1 = $this->getRandomString(5);
        $randomVal1 = $this->getRandomString(5);
        $randomKey2 = $this->getRandomString(5);
        $randomVal2 = $this->getRandomString(10);
        $randomKey3 = $this->getRandomString(10);
        $randomVal3 = $this->getRandomString(10);


        $currentPage = mt_rand(0,500);
        $perPage = mt_rand(0,500);
        $totalItems = mt_rand(0,500);
        $items = new Collection(array(
            $randomKey1 => $randomVal1,
            $randomKey2 => $randomVal2,
            $randomKey3 => $randomVal3,
        ));
        $randomKey = $this->getRandomString(10);

        $cache->putPaginated($currentPage, $perPage, $totalItems, $items, $randomKey);

        $cachedData = $cache->get($randomKey);

        // Test key correctly used
        $this->assertTrue( $cache->has($randomKey) );

        // Test top-level data saved
        $this->assertEquals( $cachedData->currentPage, $currentPage );
        $this->assertEquals( $cachedData->perPage, $perPage );
        $this->assertEquals( $cachedData->totalItems, $totalItems );

        // Test items (more complex data) saved
        $cachedCollection = $cachedData->items;
        $cachedDataArray = $cachedCollection->all();

        $this->assertInstanceOf( 'Illuminate\Support\Collection', $cachedCollection );
        $this->assertEquals( $cachedDataArray[$randomKey1], $randomVal1 );
        $this->assertEquals( $cachedDataArray[$randomKey2], $randomVal2 );
        $this->assertEquals( $cachedDataArray[$randomKey3], $randomVal3 );
    }


    protected function getLaravelCache()
    {
        // Cache, in 'test' namespace, saved for 10 minutes
        return new LaravelCache(App::make('cache'), 'test', 10);
    }

    protected function getRandomString($length)
    {
        $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $str = '';
        $count = strlen($charset);
        while ($length--) {
            $str .= $charset[mt_rand(0, $count-1)];
        }
        return $str;
    }

}