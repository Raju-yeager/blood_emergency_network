CREATE TABLE IF NOT EXISTS donors (
    id SERIAL PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    blood_group VARCHAR(10) NOT NULL CHECK (blood_group IN ('A+','A-','B+','B-','AB+','AB-','O+','O-','Bombay_Oh','Rh_null')),
    city VARCHAR(80) NOT NULL,
    is_available SMALLINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS blood_requests (
    id SERIAL PRIMARY KEY,
    hospital_name VARCHAR(150) NOT NULL,
    hospital_unit_id VARCHAR(50) NOT NULL,
    patient_blood_group VARCHAR(10) NOT NULL CHECK (patient_blood_group IN ('A+','A-','B+','B-','AB+','AB-','O+','O-','Bombay_Oh','Rh_null')),
    units_needed INT NOT NULL DEFAULT 1,
    urgency_level VARCHAR(10) NOT NULL CHECK (urgency_level IN ('Standard','Urgent','Critical')),
    contact_phone VARCHAR(15) NOT NULL,
    is_verified SMALLINT DEFAULT 0,
    status VARCHAR(10) DEFAULT 'Active' CHECK (status IN ('Pending','Active','Fulfilled')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
