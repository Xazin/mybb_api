<?php

class User {
    private int $id;
    private string $username;
    private string $avatar;
    private int $userGroup;
    private array $additionalGroups;
    private int $displayGroup;
    private string $userTitle;
    private bool $away;
    private string $awayReason;
    private int $referrer;
    private int $timeOnline;
    private float $warningPoints;

    public function __construct(array $user) {
        $this->id = $user['uid'];
        $this->username = $user['username'];
        $this->avatar = $user['avatar'];
        $this->userGroup = $user['usergroup'];
        $this->additionalGroups = $user['additionalgroups'] ? explode(',', $user['additionalgroups']) : [];
        $this->displayGroup = $user['displaygroup'];
        $this->userTitle = $user['usertitle'];
        $this->away = (bool) $user['away'];
        $this->awayReason = $user['awayreason'];
        $this->referrer = $user['referrer'];
        $this->timeOnline = $user['timeonline'];
        $this->warningPoints = $user['warningpoints'];
    }

    public function toJson(): string {
        return json_encode(
            array(
                'id' => $this->id,
                'username' => $this->username,
                'avatar' => $this->avatar,
                'usergroup' => $this->userGroup,
                'additionalgroups' => $this->additionalGroups,
                'displaygroup' => $this->displayGroup,
                'usertitle' => $this->userTitle,
                'away' => $this->away,
                'awayreason' => $this->awayReason,
                'referrer' => $this->referrer,
                'timeonline' => $this->timeOnline,
                'warningpoints' => $this->warningPoints,
            ),
            JSON_PRETTY_PRINT
        );
    }
}
