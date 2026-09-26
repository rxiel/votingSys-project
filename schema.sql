-- Schema for Online Voting System with Incumbent Officer Tracking

CREATE TABLE users (
    user_id VARCHAR(32) PRIMARY KEY,                 -- e.g., '2024-2-06591'
    user_name VARCHAR(50) NOT NULL,
    user_email VARCHAR(100) UNIQUE NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

CREATE TABLE elections (
    election_id VARCHAR(32) PRIMARY KEY,             -- e.g., '2025-2026-01'
    election_name VARCHAR(100) NOT NULL,
    election_status ENUM('upcoming', 'ongoing', 'completed', 'cancelled') NOT NULL DEFAULT 'upcoming'
);

-- Tracks active/incumbent student leaders
CREATE TABLE officers (
    officer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(32) NOT NULL,                    -- Links to the user who is the officer
    position VARCHAR(50) NOT NULL,                   -- e.g., 'President'
    term_start YEAR NOT NULL,                        -- e.g., 2024
    term_end YEAR NOT NULL,                          -- e.g., 2025
    is_active BOOLEAN NOT NULL DEFAULT TRUE,         -- Set to FALSE once the new term starts
    
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Admin registers users as candidates for specific positions in a new election cycle
CREATE TABLE candidates (
    candidate_id INT AUTO_INCREMENT PRIMARY KEY,
    election_id VARCHAR(32) NOT NULL,
    user_id VARCHAR(32) NOT NULL,                     -- An incumbent user can be listed here too!
    position VARCHAR(50) NOT NULL,                    -- Can run for the same position OR a new one

    FOREIGN KEY (election_id) REFERENCES elections(election_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,

    -- Prevents a user from registering for 2 positions in the SAME election only
    UNIQUE KEY unique_candidate_per_election (election_id, user_id)
);

-- Tracks actual votes cast by students
CREATE TABLE votes (
    vote_id INT AUTO_INCREMENT PRIMARY KEY,
    voter_id VARCHAR(32) NOT NULL,
    candidate_id INT NOT NULL,
    election_id VARCHAR(32) NOT NULL,
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (voter_id) REFERENCES users(user_id),
    FOREIGN KEY (candidate_id) REFERENCES candidates(candidate_id),
    FOREIGN KEY (election_id) REFERENCES elections(election_id),

    -- Prevents a voter from voting for the same candidate more than once
    UNIQUE KEY unique_vote_per_candidate (voter_id, candidate_id)
);