<?php

include_once __DIR__ . '/post.php';

class Thread
{
    private int $id;
    private int $fid;
    private string $subject;
    private int $uid;
    private string $author;
    private int $views;
    private int $replies;
    private bool $closed;
    private bool $sticky;
    private int $createdAt;
    private Post $post;

    public function __construct(array $thread, Post $post)
    {
        $this->id = $thread['tid'];
        $this->subject = $thread['subject'];
        $this->fid = $thread['fid'];
        $this->uid = $thread['uid'];
        $this->author = $thread['username'];
        $this->views = $thread['views'];
        $this->replies = $thread['replies'];
        $this->closed = (bool) $thread['closed'];
        $this->sticky = (bool) $thread['sticky'];
        $this->createdAt = $thread['dateline'];
        $this->post = $post;
    }

    public function toJson(): string
    {
        return json_encode(
            [
                'id' => $this->id,
                'subject' => $this->subject,
                'fid' => $this->fid,
                'uid' => $this->uid,
                'author' => $this->author,
                'views' => $this->views,
                'replies' => $this->replies,
                'closed' => $this->closed,
                'sticky' => $this->sticky,
                'createdAt' => $this->createdAt,
                'post' => $this->post->toArray(),
            ],
            JSON_PRETTY_PRINT
        );
    }
}
