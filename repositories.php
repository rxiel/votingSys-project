<?php

class UserRepository {
    public function __construct(private PDO $db) {}

    public function findById(string $userId): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        // Packing: DB Row -> Model Instance
        return new User(
            $row['user_id'],
            $row['user_name'],
            $row['user_email'],
            $row['user_password'],
            $row['user_role']
        );
    }

    public function save(User $user): bool {
        $stmt = $this->db->prepare("
            INSERT INTO users (user_id, user_name, user_email, user_password, user_role)
            VALUES (:user_id, :user_name, :user_email, :user_password, :user_role)
            ON DUPLICATE KEY UPDATE
                user_name = :user_name,
                user_email = :user_email,
                user_password = :user_password,
                user_role = :user_role
        ");

        // Unpacking: Model Getters -> SQL Execution
        return $stmt->execute([
            'user_id'       => $user->getUserID(),
            'user_name'     => $user->getUserName(),
            'user_email'    => $user->getUserEmail(),
            'user_password' => $user->getUserPassword(),
            'user_role'     => $user->getUserRole()
        ]);
    }
}


class ElectionRepository {
    public function __construct(private PDO $db) {}

    public function findById(string $electionId): ?Elections {
        $stmt = $this->db->prepare("SELECT * FROM elections WHERE election_id = :election_id");
        $stmt->execute(['election_id' => $electionId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Elections(
            $row['election_id'],
            $row['election_name'],
            $row['election_status']
        );
    }

    public function save(Elections $election): bool {
        $stmt = $this->db->prepare("
            INSERT INTO elections (election_id, election_name, election_status)
            VALUES (:election_id, :election_name, :election_status)
            ON DUPLICATE KEY UPDATE
                election_name = :election_name,
                election_status = :election_status
        ");

        return $stmt->execute([
            'election_id'     => $election->getElectionID(),
            'election_name'   => $election->getElectionName(),
            'election_status' => $election->getElectionStatus()
        ]);
    }
}


class CandidateRepository {
    public function __construct(private PDO $db) {}

    public function findById(int $candidateId): ?Candidate {
        $stmt = $this->db->prepare("SELECT * FROM candidates WHERE candidate_id = :candidate_id");
        $stmt->execute(['candidate_id' => $candidateId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Candidate(
            $row['election_id'],
            $row['user_id'],
            $row['position'],
            (int)$row['candidate_id']
        );
    }

    public function save(Candidate $candidate): bool {
        $stmt = $this->db->prepare("
            INSERT INTO candidates (election_id, user_id, position)
            VALUES (:election_id, :user_id, :position)
        ");

        $success = $stmt->execute([
            'election_id' => $candidate->getElectionID(),
            'user_id'     => $candidate->getUserID(),
            'position'    => $candidate->getPosition()
        ]);

        if ($success && $candidate->getCandidateID() === null) {
            $candidate->setCandidateID((int)$this->db->lastInsertId());
        }

        return $success;
    }
}


class OfficerRepository {
    public function __construct(private PDO $db) {}

    public function findById(int $officerId): ?Officer {
        $stmt = $this->db->prepare("SELECT * FROM officers WHERE officer_id = :officer_id");
        $stmt->execute(['officer_id' => $officerId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Officer(
            $row['user_id'],
            $row['position'],
            (int)$row['term_start'],
            (int)$row['term_end'],
            (bool)$row['is_active'],
            (int)$row['officer_id']
        );
    }

    public function save(Officer $officer): bool {
        $stmt = $this->db->prepare("
            INSERT INTO officers (user_id, position, term_start, term_end, is_active)
            VALUES (:user_id, :position, :term_start, :term_end, :is_active)
            ON DUPLICATE KEY UPDATE
                position = :position,
                term_start = :term_start,
                term_end = :term_end,
                is_active = :is_active
        ");

        $success = $stmt->execute([
            'user_id'    => $officer->getUserID(),
            'position'   => $officer->getPosition(),
            'term_start' => $officer->getTermStart(),
            'term_end'   => $officer->getTermEnd(),
            'is_active'  => $officer->getIsActive() ? 1 : 0
        ]);

        if ($success && $officer->getOfficerID() === null) {
            $officer->setOfficerID((int)$this->db->lastInsertId());
        }

        return $success;
    }
}


class VoteRepository {
    public function __construct(private PDO $db) {}

    public function save(Vote $vote): bool {
        $stmt = $this->db->prepare("
            INSERT INTO votes (voter_id, candidate_id, election_id)
            VALUES (:voter_id, :candidate_id, :election_id)
        ");

        $success = $stmt->execute([
            'voter_id'     => $vote->getVoterID(),
            'candidate_id' => $vote->getCandidateID(),
            'election_id'  => $vote->getElectionID()
        ]);

        if ($success && $vote->getVoteID() === null) {
            $vote->setVoteID((int)$this->db->lastInsertId());
        }

        return $success;
    }
}