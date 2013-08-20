<?php namespace Impl\Repo\Status;

use Impl\Repo\RepoAbstract;
use Illuminate\Database\Eloquent\Model;

class EloquentStatus extends RepoAbstract implements StatusInterface {

    protected $status;

    public function __construct(Model $status)
    {
        $this->status = $status;
    }

    /**
     * Get all Statuses
     * @return Array Arrayable collection
     */
    public function all()
    {
        return $this->status->all();
    }

    /**
     * Get specific status
     * @param  int $id Status ID
     * @return object  Status object
     */
    public function byId($id)
    {
        return $this->status->find($id);
    }

    /**
     * Get specific status
     * @param  int $id Status slug
     * @return object  Status object
     */
    public function byStatus($status)
    {
        return $this->status->where('slug', $status);
    }

}