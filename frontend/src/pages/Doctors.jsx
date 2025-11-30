import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useTranslation } from 'react-i18next';
import axios from '../api/axios';
import LanguageSwitcher from '../components/LanguageSwitcher';
import DarkModeToggle from '../components/DarkModeToggle';
import './Doctors.css';
import './Doctors-dark.css';

const Doctors = () => {
  const navigate = useNavigate();
  const { t } = useTranslation();
  const [doctors, setDoctors] = useState([]);
  const [loading, setLoading] = useState(true);
  const [selectedSpecialization, setSelectedSpecialization] = useState('all');

  const specializations = [
    { 
      id: 'all', 
      name: 'All Specializations',
      icon: (
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="36" fill="url(#allGrad)"/>
          <path d="M40 20C29 20 20 29 20 40C20 51 29 60 40 60C51 60 60 51 60 40C60 29 51 20 40 20Z" stroke="white" strokeWidth="3" fill="none"/>
          <circle cx="40" cy="40" r="4" fill="white"/>
          <path d="M40 24V36M40 44V56M24 40H36M44 40H56" stroke="white" strokeWidth="3" strokeLinecap="round"/>
          <defs>
            <linearGradient id="allGrad" x1="0" y1="0" x2="80" y2="80">
              <stop offset="0%" stopColor="#3b82f6"/>
              <stop offset="100%" stopColor="#06b6d4"/>
            </linearGradient>
          </defs>
        </svg>
      )
    },
    { 
      id: 'Cardiology', 
      name: 'Cardiology',
      icon: (
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="36" fill="url(#cardioGrad)"/>
          {/* Heart shape */}
          <path d="M40 55L25 40C22 37 22 32 25 29C28 26 33 26 36 29L40 33L44 29C47 26 52 26 55 29C58 32 58 37 55 40L40 55Z" fill="white"/>
          {/* ECG line */}
          <path d="M15 42L22 42L25 35L30 50L35 38L40 42L45 42" stroke="#ef4444" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"/>
          <defs>
            <linearGradient id="cardioGrad" x1="0" y1="0" x2="80" y2="80">
              <stop offset="0%" stopColor="#fca5a5"/>
              <stop offset="100%" stopColor="#ef4444"/>
            </linearGradient>
          </defs>
        </svg>
      )
    },
    { 
      id: 'Neurology', 
      name: 'Neurology',
      icon: (
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="36" fill="url(#neuroGrad)"/>
          {/* Brain outline */}
          <path d="M30 25C25 25 22 28 22 33C22 35 23 37 24 38C23 39 22 41 22 43C22 47 25 50 29 50C29 52 30 54 32 55C34 56 36 56 38 55C38 57 40 58 42 58C44 58 46 57 46 55C48 56 50 56 52 55C54 54 55 52 55 50C59 50 62 47 62 43C62 41 61 39 60 38C61 37 62 35 62 33C62 28 59 25 54 25C52 25 50 26 49 27C48 26 46 25 44 25C42 25 40 26 39 27C38 26 36 25 34 25C32 25 30 26 29 27C28 26 29 25 30 25Z" fill="white"/>
          {/* Neural connections */}
          <circle cx="35" cy="35" r="2" fill="#8b5cf6"/>
          <circle cx="45" cy="35" r="2" fill="#8b5cf6"/>
          <circle cx="40" cy="42" r="2" fill="#8b5cf6"/>
          <circle cx="32" cy="45" r="2" fill="#8b5cf6"/>
          <circle cx="48" cy="45" r="2" fill="#8b5cf6"/>
          <line x1="35" y1="35" x2="40" y2="42" stroke="#8b5cf6" strokeWidth="1.5"/>
          <line x1="45" y1="35" x2="40" y2="42" stroke="#8b5cf6" strokeWidth="1.5"/>
          <line x1="40" y1="42" x2="32" y2="45" stroke="#8b5cf6" strokeWidth="1.5"/>
          <line x1="40" y1="42" x2="48" y2="45" stroke="#8b5cf6" strokeWidth="1.5"/>
          <defs>
            <linearGradient id="neuroGrad" x1="0" y1="0" x2="80" y2="80">
              <stop offset="0%" stopColor="#c4b5fd"/>
              <stop offset="100%" stopColor="#8b5cf6"/>
            </linearGradient>
          </defs>
        </svg>
      )
    },
    { 
      id: 'Pediatrics', 
      name: 'Pediatrics',
      icon: (
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="36" fill="url(#pediaGrad)"/>
          {/* Baby/child figure */}
          <circle cx="40" cy="28" r="8" fill="white"/>
          <path d="M25 60C25 52 31 46 40 46C49 46 55 52 55 60" fill="white"/>
          {/* Cute face */}
          <circle cx="36" cy="27" r="1.5" fill="#f59e0b"/>
          <circle cx="44" cy="27" r="1.5" fill="#f59e0b"/>
          <path d="M36 31C36 31 38 33 40 33C42 33 44 31 44 31" stroke="#f59e0b" strokeWidth="1.5" strokeLinecap="round"/>
          {/* Toy blocks */}
          <rect x="20" y="50" width="6" height="6" fill="#fbbf24" opacity="0.8"/>
          <rect x="54" y="50" width="6" height="6" fill="#60a5fa" opacity="0.8"/>
          <defs>
            <linearGradient id="pediaGrad" x1="0" y1="0" x2="80" y2="80">
              <stop offset="0%" stopColor="#fcd34d"/>
              <stop offset="100%" stopColor="#f59e0b"/>
            </linearGradient>
          </defs>
        </svg>
      )
    },
    { 
      id: 'Dermatology', 
      name: 'Dermatology',
      icon: (
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="36" fill="url(#dermaGrad)"/>
          {/* Skin layers */}
          <ellipse cx="40" cy="40" rx="20" ry="18" fill="white" opacity="0.9"/>
          <ellipse cx="40" cy="40" rx="15" ry="13" fill="white" opacity="0.7"/>
          <ellipse cx="40" cy="40" rx="10" ry="8" fill="white" opacity="0.5"/>
          {/* Sparkles for healthy skin */}
          <path d="M28 28L29 31L32 30L30 33L33 34L30 35L31 38L28 36L25 38L26 35L23 34L26 33L24 30L27 31L28 28Z" fill="white"/>
          <path d="M52 32L53 34L55 33L54 36L57 37L54 38L55 41L52 39L49 41L50 38L47 37L50 36L48 33L51 34L52 32Z" fill="white"/>
          <path d="M40 52L41 54L43 53L42 56L45 57L42 58L43 61L40 59L37 61L38 58L35 57L38 56L36 53L39 54L40 52Z" fill="white" opacity="0.8"/>
          <defs>
            <linearGradient id="dermaGrad" x1="0" y1="0" x2="80" y2="80">
              <stop offset="0%" stopColor="#f9a8d4"/>
              <stop offset="100%" stopColor="#ec4899"/>
            </linearGradient>
          </defs>
        </svg>
      )
    },
    { 
      id: 'Orthopedics', 
      name: 'Orthopedics',
      icon: (
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="36" fill="url(#orthoGrad)"/>
          {/* Bone structure */}
          <ellipse cx="40" cy="25" rx="6" ry="8" fill="white"/>
          <rect x="36" y="28" width="8" height="24" rx="2" fill="white"/>
          <ellipse cx="40" cy="55" rx="6" ry="8" fill="white"/>
          {/* Joint indicators */}
          <circle cx="40" cy="32" r="4" fill="#64748b" opacity="0.3"/>
          <circle cx="40" cy="48" r="4" fill="#64748b" opacity="0.3"/>
          {/* Bone details */}
          <line x1="38" y1="35" x2="38" y2="45" stroke="#cbd5e1" strokeWidth="1"/>
          <line x1="42" y1="35" x2="42" y2="45" stroke="#cbd5e1" strokeWidth="1"/>
          <defs>
            <linearGradient id="orthoGrad" x1="0" y1="0" x2="80" y2="80">
              <stop offset="0%" stopColor="#94a3b8"/>
              <stop offset="100%" stopColor="#64748b"/>
            </linearGradient>
          </defs>
        </svg>
      )
    },
    { 
      id: 'General Practice', 
      name: 'General Practice',
      icon: (
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="36" fill="url(#generalGrad)"/>
          {/* Stethoscope */}
          <circle cx="40" cy="50" r="8" stroke="white" strokeWidth="3" fill="none"/>
          <path d="M32 50C32 50 32 35 32 30C32 25 35 22 40 22C45 22 48 25 48 30C48 35 48 50 48 50" stroke="white" strokeWidth="3" strokeLinecap="round" fill="none"/>
          <circle cx="40" cy="50" r="3" fill="white"/>
          {/* Earpieces */}
          <circle cx="28" cy="28" r="3" fill="white"/>
          <circle cx="52" cy="28" r="3" fill="white"/>
          <path d="M28 28C28 28 30 25 32 25" stroke="white" strokeWidth="2" strokeLinecap="round"/>
          <path d="M52 28C52 28 50 25 48 25" stroke="white" strokeWidth="2" strokeLinecap="round"/>
          <defs>
            <linearGradient id="generalGrad" x1="0" y1="0" x2="80" y2="80">
              <stop offset="0%" stopColor="#22d3ee"/>
              <stop offset="100%" stopColor="#10b981"/>
            </linearGradient>
          </defs>
        </svg>
      )
    },
  ];

  useEffect(() => {
    fetchDoctors();
  }, []);

  const fetchDoctors = async () => {
    try {
      const response = await axios.get('/doctors');
      const doctorsData = response.data.data || response.data.doctors || response.data || [];
      setDoctors(Array.isArray(doctorsData) ? doctorsData : []);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching doctors:', error);
      setDoctors([]);
      setLoading(false);
    }
  };

  const filteredDoctors = selectedSpecialization === 'all' 
    ? doctors 
    : doctors.filter(doc => doc.specialization === selectedSpecialization);

  return (
    <div className="doctors-page">
      {/* Header */}
      <header className="doctors-header">
        <div className="header-content">
          <div className="logo" onClick={() => navigate('/')}>
            <div className="logo-icon">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
                <path d="M2 17L12 22L22 17" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
                <path d="M2 12L12 17L22 12" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
              </svg>
            </div>
            <span className="logo-text">Mawidi</span>
          </div>
          <div className="header-actions">
            <DarkModeToggle />
            <LanguageSwitcher />
            <button onClick={() => navigate('/login')} className="login-btn">
              Login
            </button>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <section className="doctors-hero">
        <div className="hero-content">
          <h1>Find Your Perfect Doctor</h1>
          <p>Browse our network of qualified medical professionals</p>
        </div>
      </section>

      {/* Specializations Filter */}
      <section className="specializations-section">
        <div className="container">
          <h2 className="section-title">High-Quality Services</h2>
          <p className="section-subtitle">Choose a specialization to find the right doctor for you</p>
          
          <div className="specializations-grid">
            {specializations.map((spec) => (
              <button
                key={spec.id}
                className={`specialization-card ${selectedSpecialization === spec.id ? 'active' : ''}`}
                onClick={() => setSelectedSpecialization(spec.id)}
              >
                <div className="spec-icon-svg">{spec.icon}</div>
                <h3>{spec.name}</h3>
                <p>Medical competitive research startup in Agadir, Morocco</p>
              </button>
            ))}
          </div>
        </div>
      </section>

      {/* Doctors List */}
      <section className="doctors-list-section">
        <div className="container">
          <div className="section-header">
            <h2 className="section-title">Meet Our Specialist Doctors</h2>
            <p className="section-subtitle">
              {selectedSpecialization === 'all' 
                ? `Showing all ${filteredDoctors.length} doctors` 
                : `${filteredDoctors.length} ${selectedSpecialization} specialists`}
            </p>
          </div>

          {loading ? (
            <div className="loading-state">
              <div className="spinner-large"></div>
              <p>Loading doctors...</p>
            </div>
          ) : filteredDoctors.length === 0 ? (
            <div className="empty-state">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
              </svg>
              <h3>No doctors found</h3>
              <p>Try selecting a different specialization</p>
            </div>
          ) : (
            <div className="doctors-grid">
              {filteredDoctors.map((doctor) => (
                <div key={doctor.id} className="doctor-card">
                  <div className="doctor-image">
                    <div className="doctor-avatar">
                      <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                      </svg>
                    </div>
                    {doctor.is_teleconsultation_available && (
                      <div className="badge">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                          <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                        </svg>
                        Teleconsultation
                      </div>
                    )}
                  </div>
                  
                  <div className="doctor-info">
                    <h3 className="doctor-name">
                      Dr. {doctor.user?.first_name} {doctor.user?.last_name}
                    </h3>
                    <p className="doctor-specialization">{doctor.specialization}</p>
                    {doctor.qualifications && (
                      <p className="doctor-qualifications">{doctor.qualifications}</p>
                    )}
                    
                    <div className="doctor-details">
                      <div className="detail-item">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                          <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clipRule="evenodd" />
                        </svg>
                        <span>{doctor.consultation_duration} min</span>
                      </div>
                      <div className="detail-item">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                          <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                          <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clipRule="evenodd" />
                        </svg>
                        <span>{doctor.consultation_price} MAD</span>
                      </div>
                    </div>

                    {doctor.work_address && (
                      <div className="work-address">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                          <path fillRule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clipRule="evenodd" />
                        </svg>
                        <span>{doctor.work_address}</span>
                      </div>
                    )}

                    {doctor.spoken_languages && doctor.spoken_languages.length > 0 && (
                      <div className="languages">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                          <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clipRule="evenodd" />
                        </svg>
                        <span>{doctor.spoken_languages.join(', ')}</span>
                      </div>
                    )}

                    <button 
                      onClick={() => navigate('/login')} 
                      className="book-btn"
                    >
                      Book Appointment
                    </button>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </section>

      {/* CTA Section */}
      <section className="cta-section">
        <div className="container">
          <h2>Ready to Book Your Appointment?</h2>
          <p>Join thousands of patients who trust Mawidi for their healthcare needs</p>
          <div className="cta-buttons">
            <button onClick={() => navigate('/register')} className="btn-primary">
              Create Account
            </button>
            <button onClick={() => navigate('/login')} className="btn-secondary">
              Login
            </button>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="doctors-footer">
        <div className="container">
          <p>&copy; 2024 Mawidi. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
};

export default Doctors;
