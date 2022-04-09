<?php

class Post {
    private int $id;
    private int $tid;
    private int $fid;
    private int $uid;
    private string $author;
    private string $subject;
    private string $message;

    public function __construct(array $post) {
        $this->id = $post['pid'];
        $this->tid = $post['tid'];
        $this->fid = $post['fid'];
        $this->uid = $post['uid'];
        $this->author = $post['username'];
        $this->subject = $post['subject'];
        $this->message = $post['message'];
    }

    public function toJson(): string {
        return json_encode(
            array(
                'id' => $this->id,
                'tid' => $this->tid,
                'fid' => $this->fid,
                'uid' => $this->uid,
                'author' => $this->author,
                'subject' => $this->subject,
                'message' => $this->message,
            ),
            JSON_PRETTY_PRINT
        );
    }

    public function toArray(): array {
        return array(
            'id' => $this->id,
            'tid' => $this->tid,
            'fid' => $this->fid,
            'uid' => $this->uid,
            'author' => $this->author,
            'subject' => $this->subject,
            'message' => $this->message,
        );
    }
}