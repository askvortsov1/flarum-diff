<?php
namespace TheTurk\Diff;

use Flarum\Database\AbstractModel;
use Flarum\User\User;

/**
 * @property int $id
 * @property int $revision
 * @property string $diff
 * @property int $post_id
 * @property Post $post
 * @property int|null $actor_id
 * @property User|null $actor
 * @property int|null $deleted_user_id
 * @property User|null $deleted_user
 * @property \Carbon\Carbon $created_at
 */
class Diff extends AbstractModel
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'post_edit_histories';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at'];

    /**
     * @param $revision
     * @param $postId
     * @param $actorId
     * @param $diffs
     * @return static
     */
    public static function build($revision, $postId, $actorId, $diffs)
    {
        $diff = new static();

        $diff->revision = $revision;
        $diff->post_id = $postId;
        $diff->actor_id = $actorId;
        $diff->diff = $diffs;

        return $diff;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletedUser()
    {
        return $this->belongsTo(User::class, 'deleted_user_id')->withDefault();
    }
}
