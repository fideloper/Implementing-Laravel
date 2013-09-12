<?php namespace Impl\Repo\Status;

interface StatusInterface {

    /**
     * Get all Statuses
     * @return Array Arrayable collection
     */
    public function all();

    /**
     * Get specific status
     * @param  int $id Status ID
     * @return object  Status object
     */
    public function byId($id);

    /**
     * Get specific status
     * @param  int $id Status slug
     * @return object  Status object
     */
    public function byStatus($status);

}