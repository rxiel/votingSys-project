<?php 
// Create php classes based on the database tables

class User {
    private $user_id;
    private $user_name;
    private $user_email;
    private $user_password;
    private $user_role;
    
    // Assign values to the properties in the constructor
    public function __construct($user_id, $user_name, $user_email, $user_password, $user_role) {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->user_email = $user_email;
        $this->user_password = $user_password;
        $this->user_role = $user_role;
    }

    // Add getters and setters for each property
    // Getters for each property
    public function getUserID() {return $this->user_id;}
    public function getUserName() {return $this->user_name;}
    public function getUserEmail() {return $this->user_email;}
    public function getUserPassword() {return $this->user_password;}
    public function getUserRole() {return $this->user_role;}
    // Setters for each property
    public function setUserID($user_id) {$this->user_id = $user_id;}
    public function setUserName($user_name) {$this->user_name = $user_name;}
    public function setUserEmail($user_email) {$this->user_email = $user_email;}
    public function setUserPassword($user_password) {$this->user_password = $user_password;}
    public function setUserRole($user_role) {$this->user_role = $user_role;}
}

class Elections {

    private $election_id;
    private $election_name;
    private $election_status;
    
    // Assign values to the properties in the constructor
    public function __construct($election_id, $election_name, $election_status = 'upcoming') {
        $this->election_id = $election_id;
        $this->election_name = $election_name;
        $this->election_status = $election_status;
    }

    // Getters for each property
    public function getElectionID() { return $this->election_id; }
    public function getElectionName() { return $this->election_name; }
    public function getElectionStatus() { return $this->election_status; }

    // Setters for each property
    public function setElectionID($election_id) { $this->election_id = $election_id; }
    public function setElectionName($election_name) { $this->election_name = $election_name; }
    public function setElectionStatus($election_status) { $this->election_status = $election_status; }
}

class Candidate {
    private $candidate_id;
    private $election_id;
    private $user_id;
    private $position;

    // Assign values to the properties in the constructor
    public function __construct($election_id, $user_id, $position, $candidate_id = null) {
        $this->candidate_id = $candidate_id;
        $this->election_id = $election_id;
        $this->user_id = $user_id;
        $this->position = $position;
    }

    // Getters for each property
    public function getCandidateID() { return $this->candidate_id; }
    public function getElectionID() { return $this->election_id; }
    public function getUserID() { return $this->user_id; }
    public function getPosition() { return $this->position; }

    // Setters for each property
    public function setCandidateID($candidate_id) { $this->candidate_id = $candidate_id; }
    public function setElectionID($election_id) { $this->election_id = $election_id; }
    public function setUserID($user_id) { $this->user_id = $user_id; }
    public function setPosition($position) { $this->position = $position; }
}

class Officer {
    private $officer_id;
    private $user_id;
    private $position;
    private $term_start;
    private $term_end;
    private $is_active;

    // Assign values to the properties in the constructor
    public function __construct($user_id, $position, $term_start, $term_end, $is_active = true, $officer_id = null) {
        $this->officer_id = $officer_id;
        $this->user_id = $user_id;
        $this->position = $position;
        $this->term_start = $term_start;
        $this->term_end = $term_end;
        $this->is_active = $is_active;
    }

    // Getters for each property
    public function getOfficerID() { return $this->officer_id; }
    public function getUserID() { return $this->user_id; }
    public function getPosition() { return $this->position; }
    public function getTermStart() { return $this->term_start; }
    public function getTermEnd() { return $this->term_end; }
    public function getIsActive() { return $this->is_active; }

    // Setters for each property
    public function setOfficerID($officer_id) { $this->officer_id = $officer_id; }
    public function setUserID($user_id) { $this->user_id = $user_id; }
    public function setPosition($position) { $this->position = $position; }
    public function setTermStart($term_start) { $this->term_start = $term_start; }
    public function setTermEnd($term_end) { $this->term_end = $term_end; }
    public function setIsActive($is_active) { $this->is_active = $is_active; }
}

class Vote {
    private $vote_id;
    private $voter_id;
    private $candidate_id;
    private $election_id;
    private $voted_at;

    // Assign values to the properties in the constructor
    public function __construct($voter_id, $candidate_id, $election_id, $voted_at = null, $vote_id = null) {
        $this->vote_id = $vote_id;
        $this->voter_id = $voter_id;
        $this->candidate_id = $candidate_id;
        $this->election_id = $election_id;
        $this->voted_at = $voted_at;
    }

    // Getters for each property
    public function getVoteID() { return $this->vote_id; }
    public function getVoterID() { return $this->voter_id; }
    public function getCandidateID() { return $this->candidate_id; }
    public function getElectionID() { return $this->election_id; }
    public function getVotedAt() { return $this->voted_at; }

    // Setters for each property
    public function setVoteID($vote_id) { $this->vote_id = $vote_id; }
    public function setVoterID($voter_id) { $this->voter_id = $voter_id; }
    public function setCandidateID($candidate_id) { $this->candidate_id = $candidate_id; }
    public function setElectionID($election_id) { $this->election_id = $election_id; }
    public function setVotedAt($voted_at) { $this->voted_at = $voted_at; }
}

?>
